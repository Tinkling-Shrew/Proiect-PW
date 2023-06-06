<?php

namespace app\Controllers;

use config\db;
use PDOException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

class GraphController {
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public static function getAllGraphs(Request $request, Response $response): Response {
        $query = "SELECT path FROM graphs;";
        $search_query = "SELECT path FROM graphs WHERE name=:name";

        $params = $request->getQueryParams();

        $db = new db();

        if($params) {
            if(!$params["name"]) {
                $response->withStatus(500)->getBody()->write("No name.");
                return $response;
            }
            $result = $db->executeQuery($search_query, array(":name" => $params["name"]));
        } else {
            $result = $db->executeQuery($query);
        }

        $graphs = array();

        if(!$result) {
            return $response->withStatus(404);
        }

        foreach ($result as $graph) {
            $path = $graph["path"];
            $graphs[] = json_decode(file_get_contents($path));
        }

        $response->getBody()->write(json_encode($graphs));

        return $response;
    }

    public static function postGraph(Request $request, Response $response, array $args): Response {
        $query = "REPLACE INTO graphs (path, user_id, name) VALUES (:path, :user_id, :name)";

        $body = json_decode($request->getBody(), true);

        $directoryPath = "./data/graphs/" . $body["user"];

        if(!file_exists($directoryPath)) {
            mkdir("./data/graphs/" . $body["user"]);
        }

        $newFilePath = $directoryPath . "/" . $body["graph"]["name"] . ".json";

        file_put_contents($newFilePath, json_encode($body["graph"]["data"]));

        $db = new db();

        $db->executeQuery($query, array(":path" => $newFilePath, ":user_id" => $args["userId"], ":name" => $body["graph"]["name"]));

        $response->getBody()->write("Resources has been created successfully.");

        return $response;
    }

    public static function deleteGraphById(Request $request, Response $response, array $args): Response {
        $get_graph_query = "SELECT path FROM graphs WHERE id=:id LIMIT 1;";
        $delete_query = "DELETE FROM graphs WHERE id=:id;";

        $params = $request->getQueryParams();

        try {
            $db = new db();

            $result = $db->executeQuery($get_graph_query,array(":id" => $params["gid"]));

            // ! Get path of the file that needs to be deleted
            $filePath = $result[0]["path"];

            // ! If it does not exist in the database, means it is not in the directory
            if(!$filePath) {
                $response->getBody()->write("Resource does not exist.");
                return $response;
            }

            // ! Delete the specified file using the path from the db
            unlink($filePath);

            // ! Delete the path from the table
            $db->executeQuery($delete_query, array(":id" => $params["gid"]));

            $response->getBody()->write("Resource has been removed successfully.");
        } catch(PDOException $exception) {
            echo $exception;
        }

        return $response;
    }

    public static function getUserGraphs(Request $request, Response $response, array $args): Response {
        $query = "SELECT * FROM graphs WHERE user_id=:id;";

        try {
            $db = new db();

            $result = $db->executeQuery($query, array(":id" => $args["userId"]));

            $graphs = array();

            foreach ($result as $graph) {
                $path = $graph["path"];
                $graphs[] = json_decode(file_get_contents($path));
            }

            $response->withStatus(200)->getBody()->write(json_encode($graphs));
        } catch(PDOException $exception) {
            $response->getBody()->write(json_encode($exception));
        }

        return $response;
    }
}