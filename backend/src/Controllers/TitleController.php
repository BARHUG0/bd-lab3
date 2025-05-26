<?php
namespace App\Controllers;

use App\Models\Title;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TitleController extends BaseController
{
    public function __construct(ResponseFactory $response)
    {
        parent::__construct($response);
    }

    public function index()
    {
        return $this->success(Title::all());
    }

    public function show($id)
    {
        try {
            $title = Title::findOrFail($id);
            return $this->success($title);
        } catch (ModelNotFoundException $e) {
            return $this->error('Title not found', 404);
        }
    }

    // store, update, destroy usan success() y error() de la misma manera…
}
