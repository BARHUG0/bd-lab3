<?php
// File: src/Controllers/InstitutionController.php
namespace App\Controllers;

use App\Models\Institution;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InstitutionController extends BaseController
{
    public function __construct(ResponseFactory $response)
    {
        parent::__construct($response);
    }

    /**
     * List all institutions.
     */
    public function index(): JsonResponse
    {
        $institutions = Institution::all();
        return $this->success($institutions);
    }

    /**
     * Show a specific institution by ID.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $institution = Institution::findOrFail($id);
            return $this->success($institution);
        } catch (ModelNotFoundException $e) {
            return $this->error('Institution not found', 404);
        }
    }

    /**
     * Create a new institution.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|unique:institution,name',
        ]);

        $institution = Institution::create($data);
        return $this->success($institution, 201);
    }

    /**
     * Update an existing institution.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $institution = Institution::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->error('Institution not found', 404);
        }

        $data = $request->validate([
            'name' => "sometimes|required|string|unique:institution,name,{$id}",
        ]);

        $institution->update($data);
        return $this->success($institution);
    }

    /**
     * Delete an institution.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = Institution::destroy($id);
        if (! $deleted) {
            return $this->error('Institution not found or could not be deleted', 404);
        }
        return $this->success(null, 204);
    }
}
