<?php

namespace app\middleware;

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

function checkToken(Request $request, Response $response, $next) {
    $authorization = $request->getHeader("Authorization");

    $token = str_replace("Bearer ", "", $authorization);
    $decoded = JWT::decode($token, $_ENV["SECRET_KEY"], "HS256");

    if(!$token) {
        return $response->withStatus(498);
    }

    return $next;
}