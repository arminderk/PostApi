<?php
namespace Src\Controller;

use Src\Model\Post;

class PostController {
    private $db;
    private $requestMethod;
    private $postID;

    private $post;

    public function __construct($db, $requestMethod, $postID) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->postID = $postID;

        $this->post = new Post($db);
    }

    public function processRequest() {
        switch($this->requestMethod) {
            case 'GET':
                $response = $this->getAllPosts();
                if($this->postID) {
                    $response = $this->getPost($this->postID);
                }
                break;
            case 'POST':
                $response = $this->createPostFromRequest();
                break;
            case 'PUT':
                $response = $this->updatePostFromRequest($this->postID);
                break;
            case 'DELETE':
                $response = $this->deletePost($this->postID);
                break;
            default:
                $response = $this->responseNotFound();
                break;
        }
        header($response['status_code_header']);
        if($response['body']) {
            echo $response['body'];
        }
    }

    private function getAllPosts() {
        $result = $this->post->listAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getPost($id) {
        $result = $this->post->find($id);
        if(!$result) {
            return $this->responseNotFound();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createPostFromRequest() {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validatePost($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->post->create($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function updatePostFromRequest($id) {
        $result = $this->post->find($id);
        if(!$result) {
            return $this->responseNotFound();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validatePost($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->post->update($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    public function deletePost($id) {
        $result = $this->post->find($id);
        if (! $result) {
            return $this->responseNotFound();
        }
        $this->person->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function validatePost($input)
    {
        if (! isset($input['title'])) {
            return false;
        }
        if (! isset($input['content'])) {
            return false;
        }
        return true;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function responseNotFound() {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}