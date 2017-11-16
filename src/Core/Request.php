<?php

namespace PhpSoapRpc\Core;

use PhpHttpRpc\Core\Request as BaseRequest;

class Request extends BaseRequest
{
    const ENV = "http://schemas.xmlsoap.org/soap/envelope/";
    const ENC = "http://schemas.xmlsoap.org/soap/encoding/";
    const SCHEMA_INSTANCE = "http://www.w3.org/2001/XMLSchema-instance";
    const SCHEMA_DATA = "http://www.w3.org/2001/XMLSchema";

    const ENV_PREFIX = "SOAP-ENV";
    const ENC_PREFIX = "SOAP-ENC";
    const XSI_PREFIX = "xsi";
    const XSD_PREFIX = "xsd";
    const REQ_PREFIX = "tns";

    protected $contentType = 'text/xml';
    protected $namespace;
    protected $soapVersion = 1;

    /**
     * Request constructor.
     * @param string $methodName
     * @param array $params
     * @param string $namespace
     * @param int $soapVersion
     */
    public function __construct($methodName, array $params = array(), $namespace = null, $soapVersion = SOAP_1_1)
    {
        parent::__construct($methodName, $params);
        $this->namespace = $namespace;
        $this->soapVersion = $soapVersion;
    }

    /**
     * @return int
     */
    public function getSoapVersion()
    {
        return $this->soapVersion;
    }

    /**
     * @return null|string
     */
    public function getnamespace()
    {
        return $this->namespace;
    }

    protected function getContentType()
    {
        if ( $this->soapVersion == SOAP_1_2 )
        {
            /// @todo add also "action =..." ?
            return 'application/soap+xml';
        }
        else
        {
            return 'text/xml';
        }
    }

    public function getHTTPHeaders()
    {
        $headers = parent::getHTTPHeaders();

        if ( $this->soapVersion == SOAP_1_2 )
        {
            $headers['Accept'] = array('application/soap+xml');
        }
        else
        {
            $headers['SOAPAction'] = array($this->namespace . '/' . $this->methodName);
        }

        return $headers;
    }

    public function getHTTPBody()
    {
        /// @todo
    }

    /**
     * Builds and returns an appropriate Response object from the http data.
     *
     * @param Request $request
     * @param string $body
     * @param array $headers
     * @param array $options Allowed keys: 'debug', 'returnType', 'useExceptions'
     * @return Response
     */
    public function parseHTTPResponse($request, $body, array $headers = array(), array $options = array())
    {
        /// @todo
    }
}
