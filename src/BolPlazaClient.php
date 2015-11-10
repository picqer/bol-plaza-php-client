<?php

namespace Picqer\BolPlazaClient;

use Picqer\BolPlazaClient\Exceptions\BolPlazaClientException;
use Picqer\BolPlazaClient\Exceptions\BolPlazaClientRateLimitException;

class BolPlazaClient
{
    private $urlLive = 'https://plazaapi.bol.com';
    private $urlTesting = 'https://test-plazaapi.bol.com';

    private $testMode = false;
    private $skipSslVerification = false;

    private $publicKey;
    private $privateKey;

    /**
     * BolPlazaClient constructor.
     * @param $publicKey
     * @param $privateKey
     */
    public function __construct($publicKey, $privateKey)
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
    }

    /**
     * Enable or disable testmode (default disabled)
     * @param $mode boolean
     */
    public function setTestMode($mode)
    {
        $this->testMode = $mode;
    }

    /**
     * Skip SSL verification in communication with server, only use in test cases
     * @param bool|true $mode
     */
    public function setSkipSslVerification($mode = true)
    {
        $this->skipSslVerification = $mode;
    }

    /**
     * Get list of open orders
     * @return array
     */
    public function getOpenOrders()
    {
        $url = '/services/rest/orders/v1/open';
        $apiResult = $this->makeRequest('GET', $url);

        $openOrders = BolPlazaDataParser::createCollectionFromResponse('BolPlazaOpenOrder', $apiResult);

        return $openOrders;
    }

    /**
     * Makes the request to the server and processes errors
     *
     * @param string $method GET
     * @param string $endpoint URI of the resource
     * @param null|string $data POST data
     * @return string XML
     * @throws BolPlazaClientException
     * @throws BolPlazaClientRateLimitException
     */
    protected function makeRequest($method = 'GET', $endpoint, $data = null)
    {
        $date = gmdate('D, d M Y H:i:s T');
        $contentType = 'application/xml';
        $url = $this->getUrlFromEndpoint($endpoint);

        $signature = $this->getSignature($method, $contentType, $date, $endpoint);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Picqer BolPlaza PHP Client (picqer.com)');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-type: ' . $contentType,
            'X-BOL-Date: ' . $date,
            'X-BOL-Authorization: ' . $signature
        ]);

        if (in_array($method, ['POST', 'PUT', 'DELETE']) && ! is_null($data))
        {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        if ($this->skipSslVerification)
        {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $result = curl_exec($ch);
        $headerInfo = curl_getinfo($ch);

        $this->checkForErrors($ch, $headerInfo, $result);

        curl_close($ch);

        return $result;
    }

    /**
     * Get URL from endpoint
     *
     * @param string $endpoint
     * @return string
     */
    protected function getUrlFromEndpoint($endpoint)
    {
        if ($this->testMode) {
            return $this->urlTesting . $endpoint;
        } else {
            return $this->urlLive . $endpoint;
        }
    }

    /**
     * Calculates signature for request
     *
     * @param string $method HTTP method
     * @param string $contentType Probably only application/xml
     * @param string $date Current time (can only be 15 mins apart from Bol servers)
     * @param string $endpoint Endpoint without url
     * @return string
     */
    protected function getSignature($method, $contentType, $date, $endpoint)
    {
        $signatureBase = $method . "\n\n";
        $signatureBase .= $contentType . "\n";
        $signatureBase .= $date . "\n";
        $signatureBase .= 'x-bol-date:' . $date . "\n";
        $signatureBase .= $endpoint;

        $signature = $this->publicKey . ':' . base64_encode(hash_hmac('SHA256', $signatureBase, $this->privateKey, true));

        return $signature;
    }

    /**
     * Check if the API returned any errors
     *
     * @param resource $ch The CURL resource of the request
     * @param array $headerInfo
     * @param string $result
     * @throws BolPlazaClientException
     * @throws BolPlazaClientRateLimitException
     */
    protected function checkForErrors($ch, $headerInfo, $result)
    {
        if (curl_errno($ch)) {
            throw new BolPlazaClientException(curl_errno($ch));
        }

        if ( ! in_array($headerInfo['http_code'], array('200', '201', '204'))) // API returns error
        {
            if ($headerInfo['http_code'] == '409')
            {
                throw new BolPlazaClientRateLimitException;
            }

            $xmlObject = BolPlazaDataParser::parseXmlResponse($result);
            if (isset($xmlObject->ErrorCode) && !empty($xmlObject->ErrorCode))
            {
                throw new BolPlazaClientException($xmlObject->ErrorMessage, (int)$xmlObject->ErrorCode);
            }
        }
    }
}