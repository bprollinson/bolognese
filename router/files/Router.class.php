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
        foreach ($variableMatches as $variableMatch)
        {
            $URISpecification = str_replace($variableMatch, '[0-9]*', $URISpecification);
        }

        return preg_match($URISpecification, $uri) === 1;
    }
}
