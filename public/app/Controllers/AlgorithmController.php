<?php

namespace app\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlgorithmController {
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public static function runAlgorithm($body, $name) {
        file_put_contents("./app/algorithms/input.json", json_encode($body));

        $current_path = getcwd();

        exec("python $current_path\\app\\algorithms\\$name.py", $output);

        return file_get_contents("./app/algorithms/output.json");
    }

    public static function runAStar(Request $request, Response $response): Response {
        $body = json_decode($request->getBody());

        $response->getBody()->write(json_encode($body));

        $output = self::runAlgorithm(json_encode($body), "AStar");

        $response->getBody()->write($output);

        return $response;
    }

    public static function runBFS(Request $request, Response $response): Response {
        $body = json_decode($request->getBody());

        if(!$body) {
            $response->getBody()->write("No graph.");
            return $response;
        }

        $output = self::runAlgorithm($body, "BFS");

        $response->getBody()->write($output);

        return $response;
    }

    public static function runDFS(Request $request, Response $response): Response {
        $body = json_decode($request->getBody());

        $output = self::runAlgorithm($body, "DFS");

        $response->getBody()->write($output);
        return $response;
    }

    public static function runGreedyBFS(Request $request, Response $response): Response {
        $body = json_decode($request->getBody());

        $output = self::runAlgorithm($body, "GreedyBFS");

        $response->getBody()->write($output);
        return $response;
    }

}