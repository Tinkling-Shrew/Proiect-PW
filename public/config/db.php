<?php

namespace config;

use PDOException;
use PDO;


class db {
    function executeQuery($query, $values = []) {
        // Set the database credentials
        $dbHost = 'localhost';
        $dbName = 'graph_db';
        $dbUsername = 'graph_user';
        $dbPassword = 'graph_password';

        // Create a new PDO connection
        $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";
        $pdo = new PDO($dsn, $dbUsername, $dbPassword);

        // Prepare and execute the query
        $stmt = $pdo->prepare($query);
        $stmt->execute($values);

        // Return the results
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}