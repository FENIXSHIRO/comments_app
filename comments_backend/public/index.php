<?php

use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;
use App\Middleware\CorsMiddleware;

require_once __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set("Europe/Moscow");

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware(); 
$app->add(new BasePathMiddleware($app));
$app->addErrorMiddleware(true, true, true);

$app->add(CorsMiddleware::class);

// Подключение маршрутов
(require __DIR__ . '/../src/Routes/web.php')($app);

$app->run();
