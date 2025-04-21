<?php

namespace Framework;

class Router
{
    // create array to hold routes from route table
    private array $routes = [];

    // create method to add routes from the route table to the routes array
    // modify the $params to default an empty array
public function add(string $path, array $params = []): void
{
    $this->routes[] = [
        "path" => $path,
        "params" => $params
    ];
}



     // create method to check a URL for a matching route from the routes table
     public function matchRoute(string $path): array|bool
{
    // decodes special characters in URL
    $path = urldecode($path);

     // trims the preceeding forward slash / from URL segments
     $path = trim($path, "/");

    foreach ($this->routes as $route) {

        // call getURLData method to process route path from route table
        $pattern = $this->getURLData($route["path"]);

        if (preg_match($pattern, $path, $matches)) {

            $matches = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);

             // merge existing simple URL patterns with new variable patterns
             $params = array_merge($matches, $route["params"]);

             return $params;
        }
    }

    return false;
    }

    private function getURLData(string $route_path): string
    {
    // separate URL path into segments
    $route_path = trim($route_path, "/");

    $segments = explode("/", $route_path);

    $segment = array_map(function (string $segment): string {

        // matches simple variables from URL path segments
        if (preg_match("#^\{([a-z][a-z0-9]*)\}$#", $segment, $matches)) {
    
            $segment = "(?<" . $matches[1] . ">[^/]*)";
    
        }

        // matches complex variables with names (id and slug)
        if (preg_match("#^\{([a-z][a-z0-9]*):(.+)\}$#", $segment, $matches)) {

            // separates segment name from segment data
            return "(?<" . $matches[1] . ">" . $matches[2] . ")";
        }

        return $segment;

    }, $segments);

    // creates desired regular expression for URL variables
        return "#^" . implode("/", $segments) . "$#iu";
    }
}