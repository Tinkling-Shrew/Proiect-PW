<?php

use app\Controllers\GraphController;
use config\db;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$baseRoute = "/graphs";

if (!empty($app)) {
    // ! GET ROUTE FOR ALL GRAPHS - /graphs
    // * for testing
    // ? requires no params or body data
    $app->get($baseRoute, function (Request $request, Response  $response) {
        return GraphController::getAllGraphs($request, $response);
    });

    $app->get($baseRoute."/{userId}", function (Request $request, Response $response, array $args) {
        if(!$args["userId"]) {
            $response->getBody()->write("No user given.");
            return$response;
        }

        return GraphController::getUserGraphs($request, $response, $args);
    });

    // ! POST ROUTE - /graphs/userId
    // ? requires user id of user, TBD
    // ? id could be give by query param or body
    // ? for now, it's given in the body
    $app->post($baseRoute."/{userId}/", function (Request  $request, Response $response, array $args) {
        return GraphController::postGraph($request, $response, $args);
    });

    // ! DELETE ROUTE - /graphs/graph/delete_by_id
    // ? deletes the file from the user directory
    // ? deletes the path from the graphs table by id
    $app->delete($baseRoute."/graph/{graphId}", function(Request $request, Response $response, array $args) {
        if(!$args["graphId"]) {
            $response->getBody()->write("No graph id has been given.");
            return $response;
        }

        return GraphController::deleteGraphById($request, $response, $args);
    });
}