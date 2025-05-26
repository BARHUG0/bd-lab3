<?php
// File: src/Controllers/UsTshirtSizeController.php
namespace App\Controllers;

use App\Models\UsTshirtSize;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UsTshirtSizeController extends BaseController
{
    public function __construct(ResponseFactory $response)
    {
        parent::__construct($response);
    }

    /**
     * List all US T-shirt sizes.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $sizes = UsTshirtSize::all();
        return $this->success($sizes);
    }

    /**
     * Show a specific T-shirt size by ID.
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $size = UsTshirtSize::findOrFail($id);
            return $this->success($size);
        } catch (ModelNotFoundException $e) {
            return $this->error('T-shirt size not found', 404);
        }
    }

    /**
     * Create a new T-shirt size.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|unique:us_tshirt_size,name',
        ]);

        $size = UsTshirtSize::create($data);
        return $this->success($size, 201);
    }

    /**
     * Update an existing T-shirt size.
     */
    public function update(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $size = UsTshirtSize::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->error('T-shirt size not found', 404);
        }

        $data = $request->validate([
            'name' => "sometimes|required|string|unique:us_tshirt_size,name,{$id}",
        ]);

        $size->update($data);
        return $this->success($size);
    }

    /**
     * Delete a T-shirt size.
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        $deleted = UsTshirtSize::destroy($id);
        if (! $deleted) {
            return $this->error('T-shirt size not found or could not be deleted', 404);
        }
        return $this->success(null, 204);
    }
}
