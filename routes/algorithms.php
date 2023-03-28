<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

if (!empty($app)) {
    //
    // Breadth First Search
    //
    $app->post("/bfs", function (Request $request, Response $response) {

    });
    //
    // Depth First Search Route
    //
    $app->post("/dfs", function (Request $request, Response $response) {

    });

    $app->post("/astar", function (Request $request, Response $response) {

    });


}