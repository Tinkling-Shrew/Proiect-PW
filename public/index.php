<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;


require __DIR__ . "/config/db.php";
require __DIR__ . '/../vendor/autoload.php';

require_once "./app/Controllers/UserController.php";
require_once "./app/Controllers/GraphController.php";
require_once "./app/Controllers/AlgorithmController.php";

// Instantiate app
$app = AppFactory::create();
$app->setBasePath("/myapp/public");

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});




$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get("", function (Request $request, Response $response) {

    return $response;
});

$app->get("/", function (Request $request, Response $response) {
    return $response;
});



// ! Routes
require("app/routes/users.php");
require("app/routes/graphs.php");
require("app/routes/algorithms.php");


try {
    $app->run();
} catch (Exception $e) {
    die(json_encode(array("status" => "failed", "message" => "This action is not allowed")));
}