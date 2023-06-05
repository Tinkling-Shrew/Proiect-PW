<?php

namespace app\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController {
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public static function login(Request $request, Response $response): Response {
        return $response;
    }

    public static function register(Request $request, Response $response): Response {
        return $response;
    }

    public static function refresh(Request $request, Response $response): Response {
        return $response;
    }
}