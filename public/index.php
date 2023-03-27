<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require "../config/db.php";

require __DIR__ . '/../vendor/autoload.php';

// Instantiate app
$app = AppFactory::create();
$app->setBasePath("/myapp/public/index");

$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get("/", function (Request $request, Response $response) {
    $response->getBody()->write(__DIR__ . "\\..\\routes\\users.php");
    return $response;
});

$app->get("/fml", function (Request $request, Response $response) {
    $response->getBody()->write("fml");
    return $response;
});

require("../routes/users.php");


// Run application
 try {
     $app->run();
 } catch (Exception $e) {
     // We display an error message
     die( json_encode(array("status" => "failed", "message" => "This action is not allowed")));
 }