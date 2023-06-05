<?php

use app\Controllers\AuthController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$base_path = "/auth";

if (!empty($app)) {
    // ! GET ROUTE FOR ALL USERS
    // * for testing
    $app->post($base_path."/login", function (Request $request, Response $response) {
        return AuthController::login($request, $response);
    });

    $app->post($base_path."/register", function (Request $request, Response $response) {
       return AuthController::register($request, $response);
    });

    $app->post($base_path."/refresh", function (Request $request, Response $response) {
        return AuthController::refresh($request, $response);
    });
}