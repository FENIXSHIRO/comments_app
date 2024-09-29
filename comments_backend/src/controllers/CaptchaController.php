<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CaptchaController {
    public function verify (Request $request, Response $response) {
        $data = json_decode($request->getBody()->getContents(), true);
    $captchaToken = $data['captcha'] ?? null;

    if (!$captchaToken) {
        $response->getBody()->write(json_encode(['success' => false, 'message' => 'Captcha token is missing']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    $hcaptchaSecret = 'ES_6ac4dbea14d140bdb5afd8b19e95f0f9';

    $verifyResponse = file_get_contents('https://hcaptcha.com/siteverify', false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query([
                'secret' => $hcaptchaSecret,
                'response' => $captchaToken,
            ]),
        ],
    ]));

    $verifyResponseData = json_decode($verifyResponse, true);

    if ($verifyResponseData['success']) {
        $response->getBody()->write(json_encode(['success' => true, 'message' => 'Captcha passed']));
    } else {
        $response->getBody()->write(json_encode(['success' => false, 'message' => 'Captcha failed']));
    }

    return $response->withHeader('Content-Type', 'application/json');
    }
}