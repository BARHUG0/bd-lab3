<?php
// File: src/Controllers/StatusController.php
namespace App\Controllers;

use App\Models\Status;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatusController extends BaseController
{
    public function __construct(ResponseFactory $response)
    {
        parent::__construct($response);
    }

    /**
     * List all statuses.
     */
    public function index(): JsonResponse
    {
        $statuses = Status::all();
        return $this->success($statuses);
    }

    /**
     * Show a specific status by ID.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $status = Status::findOrFail($id);
            return $this->success($status);
        } catch (ModelNotFoundException $e) {
            return $this->error('Status not found', 404);
        }
    }

    /**
     * Create a new status.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|unique:status,name',
        ]);

        $status = Status::create($data);
        return $this->success($status, 201);
    }

    /**
     * Update an existing status.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $status = Status::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->error('Status not found', 404);
        }

        $data = $request->validate([
            'name' => "sometimes|required|string|unique:status,name,{$id}",
        ]);

        $status->update($data);
        return $this->success($status);
    }

    /**
     * Delete a status.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = Status::destroy($id);
        if (! $deleted) {
            return $this->error('Status not found or could not be deleted', 404);
        }
        return $this->success(null, 204);
    }
}
