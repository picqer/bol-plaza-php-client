<?php
class BolPlazaClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Wienkit\BolPlazaClient\BolPlazaClient
     */
    private $client;

    public function setUp()
    {
        $publicKey = getenv('PUB');
        $privateKey = getenv('PRIVKEY');

        $this->client = new Wienkit\BolPlazaClient\BolPlazaClient($publicKey, $privateKey);
        $this->client->setTestMode(true);
    }

    public function testOrderRetrieve()
    {
        $orders = $this->client->getOrders();
        $this->assertNotEmpty($orders);
        return $orders;
    }

    /**
     * @param array $orders
     * @depends testOrderRetrieve
     */
    public function testOrdersComplete(array $orders)
    {
        $this->assertEquals(count($orders), 2);
        $this->assertEquals(count($orders[0]->OrderItems), 1);
        $this->assertEquals($orders[0]->OrderItems[0]->OrderItemId, '123');
        $this->assertEquals($orders[0]->CustomerDetails->ShipmentDetails->HousenumberExtended, 'bis');
        $this->assertEquals($orders[0]->CustomerDetails->ShipmentDetails->AddressSupplement, '3 hoog achter');
        $this->assertEquals($orders[0]->CustomerDetails->ShipmentDetails->ExtraAddressInformation, 'extra adres info');
        $this->assertEquals(count($orders[1]->OrderItems), 1);
        $this->assertEquals($orders[1]->OrderItems[0]->OrderItemId, '123');
    }

    /**
     * @depends testOrderRetrieve
     * @param array $orders
     */
    public function testOrderItemCancellation(array $orders)
    {
        $orderItem = $orders[0]->OrderItems[0];
        $cancellation = new Wienkit\BolPlazaClient\Entities\BolPlazaCancellation();
        $cancellation->DateTime = '2011-01-01T12:00:00';
        $cancellation->ReasonCode = 'REQUESTED_BY_CUSTOMER';
        $result = $this->client->cancelOrderItem($orderItem, $cancellation);
        $this->assertEquals($result->eventType, 'CANCEL_ORDER');
    }

    public function testProcessShipments()
    {
        $shipment = new Wienkit\BolPlazaClient\Entities\BolPlazaShipmentRequest();
        $shipment->OrderItemId = '123';
        $shipment->ShipmentReference = 'bolplazatest123';
        $shipment->DateTime = date('Y-m-d\TH:i:s');
        $shipment->ExpectedDeliveryDate = date('Y-m-d\TH:i:s');
        $transport = new Wienkit\BolPlazaClient\Entities\BolPlazaTransport();
        $transport->TransporterCode = 'GLS';
        $transport->TrackAndTrace = '123456789';
        $shipment->Transport = $transport;
        $result = $this->client->processShipment($shipment);
        $this->assertEquals($result->eventType, 'CONFIRM_SHIPMENT');
    }

    public function testGetShipments()
    {
        $shipments = $this->client->getShipments();
        $this->assertEquals(count($shipments), 2);
        return $shipments;
    }

    public function testGetReturnItems()
    {
        $returnItems = $this->client->getReturnItems();
        $this->assertEquals(count($returnItems), 1);
        $this->assertEquals($returnItems[0]->ReturnNumber, "0");
        $this->assertEquals($returnItems[0]->OrderId, "1");
        $this->assertEquals($returnItems[0]->EAN, "Test EAN");
        $this->assertEquals($returnItems[0]->Quantity, "2");
        return $returnItems;
    }

    /**
     * @depends testGetReturnItems
     * @param array $returnItems
     */
    public function testHandleReturnItem(array $returnItems)
    {
        $returnItem = $returnItems[0];
        $returnStatus = new Wienkit\BolPlazaClient\Entities\BolPlazaReturnItemStatusUpdate();
        $returnStatus->StatusReason = 'PRODUCT_RECEIVED';
        $returnStatus->QuantityReturned = '2';
        $result = $this->client->handleReturnItem($returnItem, $returnStatus);
        $this->assertEquals($result->eventType, 'HANDLE_RETURN_ITEM');
    }

    /**
     * @depends testGetShipments
     * @param array $shipments
     */
    public function testChangeTransport(array $shipments)
    {
        $shipment = $shipments[0];
        $changeRequest = new Wienkit\BolPlazaClient\Entities\BolPlazaChangeTransportRequest();
        $changeRequest->TransporterCode = '3SNEW941245';
        $changeRequest->TrackAndTrace = 'DPD-BE';
        $result = $this->client->changeTransport($shipment, $changeRequest);
        $this->assertEquals($result->eventType, 'CHANGE_TRANSPORT');
    }

    public function testGetPayments()
    {
        $period = '201601';
        $payments = $this->client->getPayments($period);
        $this->assertEquals(count($payments), 2);
    }

    public function testGetProcessStatus()
    {
        $processStatusId = '1';
        $result = $this->client->getProcessStatus($processStatusId);
        $this->assertEquals($result->eventType, 'CHANGE_TRANSPORT');
    }

    public function testCreateOffer()
    {
        $offerCreate = new Wienkit\BolPlazaClient\Entities\BolPlazaOfferCreate();
        $offerCreate->EAN = '0619659077013';
        $offerCreate->Condition = 'NEW';
        $offerCreate->Price = '10.00';
        $offerCreate->DeliveryCode = '24uurs-16';
        $offerCreate->QuantityInStock = '1';
        $offerCreate->Publish = 'true';
        $offerCreate->ReferenceCode = '1234567890';
        $offerCreate->Description = 'This is a new product so this description is of no use.';
        return $this->client->createOffer("1", $offerCreate);
    }

    public function testUpdateOffer()
    {
        $offerUpdate = new Wienkit\BolPlazaClient\Entities\BolPlazaOfferUpdate();
        $offerUpdate->Price = '12.00';
        $offerUpdate->DeliveryCode = '24uurs-16';
        $offerUpdate->Publish = 'true';
        $offerUpdate->ReferenceCode = '1234567890';
        $offerUpdate->Description = 'This is a new product so this description is of no use.';
        return $this->client->updateOffer("1", $offerUpdate);
    }

    public function testUpdateOfferStock()
    {
        $stockUpdate = new Wienkit\BolPlazaClient\Entities\BolPlazaStockUpdate();
        $stockUpdate->QuantityInStock = '2';
        return $this->client->updateOfferStock("1", $stockUpdate);
    }

    public function testDeleteOffer()
    {
        return $this->client->deleteOffer("1");
    }

    public function testGetOwnOffers()
    {
        $result = $this->client->getOwnOffers();
        $this->assertEquals($result->Url, 'https://test-plazaapi.bol.com/offers/v1/export/offers.csv');
        return $result->Url;
    }

    /**
     * @param $url
     * @depends testGetOwnOffers
     */
    public function testGetOwnOffersResult($url)
    {
        $result = $this->client->getOwnOffersResult($url);
        self::assertNotNull($result);
        self::assertStringStartsWith("OfferId,", $result);
    }
}
