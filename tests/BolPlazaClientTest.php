<?php

use Picqer\BolPlazaClient\BolPlazaClient;
use Picqer\BolPlazaClient\Request\CurlHttpRequest;

class BolPlazaClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var BolPlazaClient|PHPUnit_Framework_MockObject_MockObject
     */
    private $clientWithMockedHttpRequest;

    /** @var BolPlazaClient */
    private $client;

    /** @var CurlHttpRequest|PHPUnit_Framework_MockObject_MockObject */
    private $httpRequestMock;

    public function setUp()
    {
        $publicKey = getenv('PHP_PUBKEY');
        $privateKey = getenv('PHP_PRIVKEY');

        // Set regular client which connects to bol.com test env.
        $this->client = new BolPlazaClient($publicKey, $privateKey);
        $this->client->setTestMode(true);

        // Set client with mock request class
        $this->httpRequestMock = $this->createMock(CurlHttpRequest::class);
        $this->clientWithMockedHttpRequest = $this
            ->getMockBuilder(BolPlazaClient::class)
            ->setConstructorArgs([$publicKey, $privateKey])
            ->setMethods(['createHttpRequest'])
            ->getMock();
        $this->clientWithMockedHttpRequest->expects($this->any())
            ->method('createHttpRequest')
            ->willReturn($this->httpRequestMock);
        $this->clientWithMockedHttpRequest->setTestMode(true);
    }

    public function testOrderRetrieve()
    {
        $this->setupMockResponse('v2.1/get_orders');
        $orders = $this->clientWithMockedHttpRequest->getOrders();
        $this->assertNotEmpty($orders);
        return $orders;
    }

    /**
     * @param array $orders
     * @depends testOrderRetrieve
     */
    public function testOrdersComplete(array $orders)
    {
        $this->assertEquals(1, count($orders));
        $this->assertEquals(1, count($orders[0]->OrderItems));
        $this->assertEquals('2012345678', $orders[0]->OrderItems[0]->OrderItemId);
        $this->assertEquals('B', $orders[0]->CustomerDetails->ShipmentDetails->HousenumberExtended);;
    }

    /**
     * @depends testOrderRetrieve
     * @param array $orders
     */
    public function testOrderItemCancellation(array $orders)
    {
        $orderItem = $orders[0]->OrderItems[0];
        $cancellation = new Picqer\BolPlazaClient\Entities\BolPlazaCancellation();
        $cancellation->DateTime = '2011-01-01T12:00:00';
        $cancellation->ReasonCode = 'REQUESTED_BY_CUSTOMER';
        $result = $this->client->cancelOrderItem($orderItem, $cancellation);
        $this->assertEquals($result->eventType, 'CANCEL_ORDER');
    }

    public function testProcessShipments()
    {
        $this->setupMockResponse('v2.1/process_shipments');
        $shipment = new Picqer\BolPlazaClient\Entities\BolPlazaShipmentRequest();
        $shipment->OrderItemId = '123';
        $shipment->ShipmentReference = 'bolplazatest123';
        $shipment->DateTime = date('Y-m-d\TH:i:s');
        $shipment->ExpectedDeliveryDate = date('Y-m-d\TH:i:s');
        $transport = new Picqer\BolPlazaClient\Entities\BolPlazaTransport();
        $transport->TransporterCode = 'GLS';
        $transport->TrackAndTrace = '123456789';
        $shipment->Transport = $transport;
        $result = $this->clientWithMockedHttpRequest->processShipment($shipment);
        $this->assertEquals($result->eventType, 'CONFIRM_SHIPMENT');
    }

    public function testGetShipments()
    {
        $this->setupMockResponse('v2.1/get_shipments');
        $shipments = $this->clientWithMockedHttpRequest->getShipments();
        $this->assertEquals(1, count($shipments));
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
        $returnStatus = new Picqer\BolPlazaClient\Entities\BolPlazaReturnItemStatusUpdate();
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
        $this->markTestSkipped('Skipped because of incomplete bol.com test environment');

        $shipment = $shipments[0];
        $changeRequest = new Picqer\BolPlazaClient\Entities\BolPlazaChangeTransportRequest();
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
        $this->markTestSkipped('Skipped because of incomplete bol.com test environment');

        $offerCreate = new Picqer\BolPlazaClient\Entities\BolPlazaOfferCreate();
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
        $this->markTestSkipped('Skipped because of incomplete bol.com test environment');

        $offerUpdate = new Picqer\BolPlazaClient\Entities\BolPlazaOfferUpdate();
        $offerUpdate->Price = '12.00';
        $offerUpdate->DeliveryCode = '24uurs-16';
        $offerUpdate->Publish = 'true';
        $offerUpdate->ReferenceCode = '1234567890';
        $offerUpdate->Description = 'This is a new product so this description is of no use.';
        return $this->client->updateOffer("1", $offerUpdate);
    }

    public function testUpdateOfferStock()
    {
        $this->markTestSkipped('Skipped because of incomplete bol.com test environment');

        $stockUpdate = new Picqer\BolPlazaClient\Entities\BolPlazaStockUpdate();
        $stockUpdate->QuantityInStock = '2';
        return $this->client->updateOfferStock("1", $stockUpdate);
    }

    public function testDeleteOffer()
    {
        $this->markTestSkipped('Skipped because of incomplete bol.com test environment');

        return $this->client->deleteOffer("1");
    }

    public function testGetOwnOffers()
    {
        $this->markTestSkipped('Skipped because of incomplete bol.com test environment');

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
        $this->markTestSkipped('Skipped because of incomplete bol.com test environment');

        $result = $this->client->getOwnOffersResult($url);
        self::assertNotNull($result);
        self::assertStringStartsWith("OfferId,", $result);
    }

    private function setupMockResponse($path)
    {
        $this->httpRequestMock->expects($this->any())
            ->method('execute')
            ->willReturn(file_get_contents(__DIR__ . '/responses/' . $path . '.xml'));
    }
}
