<?php

use App\Controllers\CommentController;
use App\Controllers\CaptchaController;
use Slim\App;

return function (App $app) {
    $app->get('/comments/all', [CommentController::class, 'getAll']);
    $app->post('/comments/add', [CommentController::class, 'add']);
    $app->delete('/comments/delete/{id}', [CommentController::class, 'delete']);

    $app->post('/captcha/verify', [CaptchaController::class,'verify']);

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });
};
