<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use Framework\Exceptions\PageNotFoundException;


$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// include the router file with the Router class definition
//require "src/router.php";

spl_autoload_register( function (string $class_name) {

    //var_dump("src/" . str_replace("\\", "/", $class_name) . ".php");
    require "src/" . str_replace("\\", "/", $class_name) . ".php";

});

// create a new Router object from the Router class
$router = new Framework\Router;


// begin adding routes to the router table

// new route pattern in index.php
$router->add("/{controller}/{action}");
$router->add("/product/{slug:[\w-]+}", ["controller" => "products", "action" => "show"]);
$router->add("/{controller}/{id:\d+}/{action}");
$router->add("/home/index", ["controller" => "home", "action" => "index"]);
$router->add("/products", ["controller" => "products", "action" => "index"]);
$router->add("/products/show", ["controller" => "products", "action" => "show"]);
$router->add("/", ["controller" => "home", "action" => "index"]);
//$router->add("/{controller}/{action}");
$router->add("/products/index", ["controller" => "products", "action" => "index"]);

//$router->add("/", ["controller" => "home", "action" => "index"]);
//$router->add("/products", ["controller" => "products", "action" => "index"]);
//$router->add("/products/show", ["controller" => "products", "action" => "show"]);

//$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//echo "<pre>Path: $path</pre>";

// call to matchRoute() to return an array of $params from $routes
$params = $router->matchRoute($path);

//print_r($params);


// check for non-existent route
if ($params === false) {

    throw new PageNotFoundException("No matching route for '$path'.");

}

// Check if 'id' param exists
if (!empty($params["id"])) {
    $id = $params["id"];
} else {
    $id = null;
}


// edit these variables to assign values from $params array from Router class
$controller = $params["controller"];
$action = $params["action"];

// require the necessary controller using the variable value
//require "src/App/Controllers/$controller.php";
$controller = "App\Controllers\\" . ucwords($params["controller"]);

// assign the name of the desired controller to a $controller_object variable
$controller_object = new $controller;

// call the method from the controller using the $action value
$controller_object->$action();