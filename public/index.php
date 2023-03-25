<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db.php';

// Instantiate app
$app = AppFactory::create();
$app->setBasePath("/myapp/public");

$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Add route callbacks
$app->get('/', function (Request $request, Response $response, array $args) {
    $db = new DB();

    $result = $db->query("SELECT * FROM users;");

    if($result) {
        $result_string = "Rows:<br>";

        while($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $result_string .= implode("_", $row) . "<br>";
        }

        $response->getBody()->write($result_string);
    } else {
        $response->getBOdy()->write("No data.");
    }


    return $response;
});

// Run application
$app->run();

