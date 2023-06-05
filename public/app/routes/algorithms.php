<?php

use app\Controllers\AlgorithmController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


if (!empty($app)) {
    $app->post("/execute/{alg}", function (Request $request, Response $response, array $args) {
        $algorithm = $args["alg"];

        $algorithm = strtolower($algorithm);

//        $response->getBody()->write("$algorithm");

        switch ($algorithm) {
            case "astar": return AlgorithmController::runAStar($request, $response);
            case "bfs": return AlgorithmController::runBFS($request, $response);
            case "dfs": return AlgorithmController::runDFS($request, $response);
            case "greedybfs": return AlgorithmController::runGreedyBFS($request, $response);
            default: {
                echo "Algorithm does not exist.";
                return $response;
            }
        }
    });
}