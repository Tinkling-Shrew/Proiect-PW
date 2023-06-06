<?php

namespace app\Controllers;

use config\db;
use PDOException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController {
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public static function getAllUsers(Request $request, Response $response): Response {
        $sql = "SELECT * FROM users";

        $db = new db();

        $result = $db->executeQuery($sql);

        $response->getBody()->write(json_encode($result));
        $response->withStatus(200);

        return $response;
    }

    public static function getUser(Request $request, Response $response, array $args): Response {
        $query = "SELECT * FROM users WHERE email=:email AND password=:password";

        $data = $request->getQueryParams();

        $email = $data["email"];
        $password = $data["password"];

        try {
            $db = new db();

            $user = $db->executeQuery($query, array(':email' => $email,':password' => $password));

            $response->getBody()->write(json_encode($user));
            $response->withStatus(200);

        } catch(PDOException $exception) {
            $response->getBody()->write(json_encode($exception));
        }

        return $response;
    }

    public static function postUser(Request $request, Response $response): Response {
        $query = "INSERT INTO users (email, password) VALUES (:email, :password)";

        try {
            $db = new db();

            $data = json_decode($request->getBody(), true);

            $email = $data["email"];
            $password = $data["password"];

            $query_check = "SELECT * FROM users WHERE email=:email";

            $result = $db->executeQuery($query_check, array(":email" => $email));

            if($result) {
                $response->getBody()->write("Resource already exists.");
                return $response->withStatus(409);
            }

            $db->executeQuery($query, array(":email" => $email, ":password" => password));

            $response->getBody()->write(json_encode("Object created successfully."));

            return $response->withStatus(201);
        }catch(PDOException $exception) {
            $response->getBody()->write(json_encode($exception));
        }

        return $response;
    }

    public static function deleteUserById(Request $request, Response $response, array $args): Response {
        $query = "DELETE FROM users WHERE id=:id";

        try {
            $db = new db();

            $db->executeQuery($query, array(":id" => $args["id"]));

            $response->getBody()->write(json_encode("Resource deleted successfully."));
        } catch(PDOException $exception) {
            $response->getBody()->write(json_encode($exception));
        }

        return $response;
    }
}