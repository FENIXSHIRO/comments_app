<?php

namespace App\Controllers;

use App\Models\Comment;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CommentController
{
    protected $comment;

    public function __construct()
    {
        $this->comment = new Comment();
    }

    public function getAll(Request $request, Response $response)
    {
        try {
            $comments = $this->comment->getAllComments();
            $response->getBody()->write(json_encode($comments));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } catch (\Exception $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    }

    public function add(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        try {
            $addedComment = $this->comment->addComment($data['Comment_username'], $data['Comment_content']);
            $response->getBody()->write(json_encode(['message' => 'Comment added successfully', 'comment' => $addedComment]));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } catch (\Exception $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    }

    public function delete(Request $request, Response $response, array $args)
    {
        try {
            $this->comment->deleteComment($args['id']);
            $response->getBody()->write(json_encode(['message' => 'Comment deleted successfully']));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } catch (\Exception $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    }
}
