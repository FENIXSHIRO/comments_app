<?php

use App\Models\db;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set("Europe/Moscow");

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->add(new BasePathMiddleware($app));
$app->addErrorMiddleware(true, true, true);

$app->get('/', function (Request $request, Response $response) {
   $response->getBody()->write('Hello World!');
   return $response;
});

$app->addBodyParsingMiddleware();

$app->get('/comments/all', function (Request $request, Response $response) {
    $sql = "SELECT * FROM Comments.Comments";
   
    try {
      $db = new Db();
      $conn = $db->connect();
      $stmt = $conn->query($sql);
      $comments = $stmt->fetchAll(PDO::FETCH_OBJ);
      $db = null;
     
      $response->getBody()->write(json_encode($comments));
      return $response
        ->withHeader('content-type', 'application/json')
        ->withStatus(200);
    } catch (PDOException $e) {
      $error = array(
        "message" => $e->getMessage()
      );
   
      $response->getBody()->write(json_encode($error));
      return $response
        ->withHeader('content-type', 'application/json')
        ->withStatus(500);
    }
});

$app->post('/comments/add', function (Request $request, Response $response, array $args) {
 $data = $request->getParsedBody();
 $username = $data["username"];
 $content = $data["content"];
 $datetime = date("Y-m-d H:i:s");

 $sql = "INSERT INTO Comments.Comments (Comment_username, Comment_content, Comment_datetime) VALUES (:username, :content, :datetime);";

 try {
   $db = new Db();
   $conn = $db->connect();
  
   $stmt = $conn->prepare($sql);
   $stmt->bindParam(':username', $username);
   $stmt->bindParam(':content', $content);
   $stmt->bindParam(':datetime', $datetime);

   $result = $stmt->execute();

   $db = null;
   $response->getBody()->write(json_encode($result));
   return $response
     ->withHeader('content-type', 'application/json')
     ->withStatus(200);
 } catch (PDOException $e) {
   $error = array(
     "message" => $e->getMessage()
   );

   $response->getBody()->write(json_encode($error));
   return $response
     ->withHeader('content-type', 'application/json')
     ->withStatus(500);
 }
});

$app->delete('/comments/delete/{id}', function (Request $request, Response $response, array $args) {
    $id = $args["id"];
   
    $sql = "DELETE FROM Comments.Comments WHERE Comment_Id = $id";
   
    try {
      $db = new Db();
      $conn = $db->connect();
     
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute();
   
      $db = null;
      $response->getBody()->write(json_encode($result));
      return $response
        ->withHeader('content-type', 'application/json')
        ->withStatus(200);
    } catch (PDOException $e) {
      $error = array(
        "message" => $e->getMessage()
      );
   
      $response->getBody()->write(json_encode($error));
      return $response
        ->withHeader('content-type', 'application/json')
        ->withStatus(500);
    }
});

$app->run();