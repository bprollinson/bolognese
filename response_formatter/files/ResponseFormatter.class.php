<?php

require_once('vendor/bprollinson/bolognese-controller-api/src/MethodInvoked.class.php');
require_once('ResponseFormatted.class.php');
require_once('vendor/bprollinson/bolognese-response-formatter-api/src/HTTPResponse.class.php');

class ResponseFormatter
{
    private $responseMappingFile;

    public function __construct($responseMappingFile)
    {
        $this->responseMappingFile = $responseMappingFile;
    }

    public function format(MethodInvoked $methodInvoked)
    {
        $responseMappingFileContents = file_get_contents($this->responseMappingFile);
        $responseMapping = json_decode($responseMappingFileContents, true);

        foreach ($responseMapping['mapping'] as $possibleResponseType)
        {
            if ($methodInvoked->getResponse() == $possibleResponseType['key'])
            {
                $responseBody = json_encode($methodInvoked->getResponseValue());
                $httpResponse = new HTTPResponse($possibleResponseType['httpStatusCode'], $possibleResponseType['headers'], $responseBody);

                return new ResponseFormatted($httpResponse);
            }
        }

        $responseBody = json_encode($methodInvoked->getResponseValue());
        $defaultResponseType = $responseMapping['default'];
        $httpResponse = new HTTPResponse($defaultResponseType['httpStatusCode'], $defaultResponseType['headers'], $responseBody);

        return new ResponseFormatted($httpResponse);
    }
}
