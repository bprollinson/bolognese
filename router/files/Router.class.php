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

            $methodInvocation = $possibleRoute['methodInvocation'];

            return new MethodInvocation(
                $methodInvocation['namespace'],
                $methodInvocation['class'],
                $methodInvocation['method']
            );
        }

        return null;
    }
}
