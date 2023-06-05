<?php

use app\Controllers\UserController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$base_path = "/users";

if (!empty($app)) {
    // ! GET ROUTE FOR ALL USERS
    // * for testing
    $app->get($base_path, function(Request $request, Response $response) {
        return UserController::getAllUsers($request, $response);
    });

    // ! GET USER BY ID ROUTE - /users/id
    $app->get($base_path."/user/{id}", function(Request $request, Response $response, $args) use ($app) {
        if(!$args["id"]) {
            return $response->withStatus(401)->getBody()->write(json_encode("No user id."));
        }
        return UserController::getUserById($request, $response, $args);
    });

    // ! POST Route - /users/user
    // ? user in body
    $app->post($base_path."/user", function (Request $request, Response $response) {
        return UserController::postUser($request, $response);
    });
    // ! DELETE ROUTE - /users/delete_user?id=1
    $app->delete($base_path."/user/{id}", function (Request $request, Response $response, array $args) {
        if(!$args["id"]) {
            return $response->withStatus(403)->getBody()->write(json_encode("No user id."));
        }

        return UserController::deleteUserById($request, $response, $args);
    });
}