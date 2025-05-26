<?php
// File: src/Controllers/BaseController.php
namespace App\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;

abstract class BaseController
{
    protected ResponseFactory $res;

    public function __construct(ResponseFactory $response)
    {
        $this->res = $response;
    }

    protected function success($data, int $status = 200)
    {
        return $this->res->json([
            'status' => 'success',
            'data'   => $data,
        ], $status);
    }

    protected function error(string $message, int $status)
    {
        return $this->res->json([
            'status'  => 'error',
            'message' => $message,
        ], $status);
    }
}
