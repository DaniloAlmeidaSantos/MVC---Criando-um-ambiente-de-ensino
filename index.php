<?php
require __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router(URL_BASE);

/*
 * Controllers 
 */
$router->namespace("Source\Contollers");

/*
 * Web 
 */
$router->group(null);
$router->get("/", "Web:home");
$router->get("/{filter}", "Web:home");

/*
* ERRORS
*/
$router->group("oops");
$router->get("/{errcode}", "web:error");

$router->dispatch();

if ($router->error()):
    $router->redirect("/oops/{$router->error()}");
endif;