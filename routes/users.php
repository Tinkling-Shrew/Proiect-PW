<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

if (!empty($app)) {
    // ! Get all users
    $app->get("/users", function(Request $request, Response $response) {
        $sql = "SELECT * FROM main.users";

        try {
            $db = new DB();

            $result = $db->query($sql);
            $users = array();

            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $users[] = $row;
            }

            $db = null;

            $response->getBody()->write(json_encode($users));
            $response->withStatus(200);


        } catch(PDOException $exception) {
            $response->getBody()->write(json_encode($exception));
        }
        return $response;
    });

    // ! Get user by id params
    $app->get("/user", function(Request $request, Response $response, $args) use ($app) {
        $query = "SELECT * FROM main.users WHERE ID=:id";

        try {
            $db = new DB();

            // ESTE DICTIONAR CU  NU ARRAY SIMPLU
            $params = $request->getQueryParams();

            echo $params["id"];

            $statement = $db->prepare($query);
            $statement->bindParam("id", $params["id"]);

            $result = $statement->execute();
            $users = array();

            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $users[] = $row;


            $db = null;

            $response->getBody()->write(json_encode($users));
            $response->withStatus(200);

            }
        } catch(PDOException $exception) {
            $response->getBody()->write(json_encode($exception));
        }

        return $response;
    });

    $app->post("/user", function (Request $request, Response $response) {
        $query = "INSERT INTO users (email, pass) VALUES (:email, :pass)";


        try {
            $db = new DB();

            $data = json_decode($request->getBody(), true);

            $email = $data["email"];
            $pass = $data["pass"] ;

            $query_check = "SELECT * FROM users WHERE email=:email";

            $statement_check = $db->prepare($query_check);
            $statement_check->bindParam(":email", $email);

            $result = $statement_check->execute();

            if($result) {
                $response->getBody()->write("Resource already exists.");
                return $response->withStatus(409);
            }

            $statement = $db->prepare($query);
            $statement->bindParam(":email", $email);
            $statement->bindParam(":pass", $pass);

            $statement->execute();

            $response->getBody()->write(json_encode("Object created successfully."));

            return $response->withStatus(201);
        }catch(PDOException $exception) {
            $response->getBody()->write(json_encode($exception));
        }

        return $response;
    });

    $app->delete("/user", function (Request $request, Response $response) {
        $query = "DELETE FROM users WHERE id=:id";

        $params = $request->getQueryParams();

        if(!$params["id"]) {
            return $response->withStatus(403);
        }

        try {
            $db = new DB();

            $statement = $db->prepare($query);
            $statement->bindParam(":id", $params["id"]);

            $statement->execute();

            $response->getBody()->write("Resource deleted successfully.");

        } catch(PDOException $exception) {
            $response->getBody()->write(json_encode($exception));
        }

        return $response;
    });
}