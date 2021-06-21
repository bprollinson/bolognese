<?php

require_once('Request.class.php');
require_once('MethodInvocation.class.php');

class Router
{
    private $routesFile;

    public function __construct(string $routesFile)
    {
        $this->routesFile = $routesFile;
    }

    public function route(Request $request)
    {
        $routesFileContents = file_get_contents($this->routesFile);
        $routesArray = json_decode($routesFileContents, true);

        foreach ($routesArray as $possibleRoute)
        {
            if ($request->getMethod() != $possibleRoute['request']['method'])
            {
                continue;
            }

            if (!$this->URIsMatch($request->getURI(), $possibleRoute['request']))
            {
                continue;
            }

            $methodInvocation = $possibleRoute['methodInvocation'];

            return new MethodInvocation(
                $methodInvocation['hostname'],
                $methodInvocation['namespace'],
                $methodInvocation['class'],
                $methodInvocation['method']
            );
        }

        return null;
    }

    private function URIsMatch($uri, $requestSpecification)
    {
        $variableMatches = [];
        preg_match_all("#{.*?}#", $requestSpecification['uri'], $variableMatches);
        $URISpecification = "#^{$requestSpecification['uri']}$#";
        foreach ($variableMatches[0] as $variableMatch)
        {
            $variableName = substr($variableMatch, 1, -1);
            $variableRegularExpression = $this->buildVariableRegularExpression($variableName, $requestSpecification['params']);
            if ($variableRegularExpression === null)
            {
                return false;
            }

            $URISpecification = str_replace($variableMatch, $variableRegularExpression, $URISpecification);
        }

        return preg_match($URISpecification, $uri) === 1;
    }

    private function buildVariableRegularExpression($variableName, $params)
    {
        $matchingParams = array_filter($params, function($param) use ($variableName) {
            return $param['name'] == $variableName;
        });

        if (count($matchingParams) == 0)
        {
            return null;
        }

        $matchingParams = array_values($matchingParams);

        switch ($matchingParams[0]['type'])
        {
            case 'natural':
                return '[0-9]*';
            case 'alpha':
                return '[a-zA-Z]*';
            default:
                return null;
        }
    }
}
