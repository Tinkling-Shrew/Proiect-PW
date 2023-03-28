<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

if (!empty($app)) {
    //
    // ! GET ROUTE FOR ALL GRAPHS
    // ? requires no params or body data
    //
    $app->get("/graphs", function (Request $request, Response  $response) {
        $files = array_diff(scandir("./graphs"), array("..", "."));
        $files_contents = array();

        foreach ($files as $file) {
            $files_contents[] = json_encode(file_get_contents("./graphs/" . $file));
        }

        $response->getBody()->write(json_encode($files_contents));

        return $response;
    });
    //
    // ! POST ROUTE
    // ? requires user id of user, TBD
    // ? id could be give by query param or body
    // ? for now, it's given in the body
    //
    $app->post("/graph", function (Request  $request, Response $response) {
        $query = "REPLACE INTO graphs (path) VALUES (:path)";

        $params = $request->getQueryParams();
        $body = json_decode($request->getBody(), true);

        $directoryPath = "./graphs/" . $body["user"];

        if(!file_exists($directoryPath)) {
            mkdir("./graphs/" . $body["user"]);
        }

        $newFilePath = "./graphs/" . $body["user"] . "/" . $body["graph"]["name"] . ".json";

        try {
            file_put_contents($newFilePath, json_encode($body["graph"]["data"]));

            $db = new DB();

            $statement = $db->prepare($query);
            $statement->bindParam(":path",$newFilePath);
            $statement->execute();

            $response->getBody()->write("Resources has been created successfully.");

        } catch (PDOException $exception) {
            echo $exception;
        }

        return $response;
    });
    //
    // ! DELETE ROUTE
    // ? deletes the file from the user directory
    // ? deletes the path from the graphs table by id
    //
    $app->delete("/graph", function(Request $request, Response $response) {
        $get_graph_query = "SELECT path FROM graphs WHERE id=:id LIMIT 1;";
        $delete_query = "DELETE FROM graphs WHERE id=:id;";

        $params = $request->getQueryParams();

        if(!$params["gid"] || !$params["uid"]) {
            $response->getBody()->write("No graph id has been given.");
            return $response;
        }

        try {
            $db = new DB();

            $get_statement = $db->prepare($get_graph_query);
            $get_statement->bindParam(":id", $params["gid"]);
            $get_result = $get_statement->execute();

            $filePath = "";

            // ! Get path of the file that needs to be deleted
            while ($row = $get_result->fetchArray(SQLITE3_ASSOC)) {
                $filePath = $row;
            }

            // ! If it does not exist in the database, means it is not in the directory
            if(!$filePath) {
                $response->getBody()->write("Resource does not exist.");
                return $response;
            }

            // ! Delete the specified file using the path from the db
            unlink($filePath);

            // ! Delete the path from the table
            $delete_statement = $db->prepare($delete_query);
            $delete_statement->bindParam(":id", $params["gid"]);
            $delete_statement->execute();

            $response->getBody()->write("Resource has been removed successfully.");
        } catch(PDOException $exception) {
            echo $exception;
        }

        return $response;
    });
}