<?php
// File: src/Controllers/TeamRoleController.php
namespace App\Controllers;

use App\Models\TeamRole;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamRoleController extends BaseController
{
    public function __construct(ResponseFactory $response)
    {
        parent::__construct($response);
    }

    /**
     * List all team roles.
     */
    public function index(): JsonResponse
    {
        $roles = TeamRole::all();
        return $this->success($roles);
    }

    /**
     * Show a specific team role by ID.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $role = TeamRole::findOrFail($id);
            return $this->success($role);
        } catch (ModelNotFoundException $e) {
            return $this->error('TeamRole not found', 404);
        }
    }

    /**
     * Create a new team role.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|unique:team_role,name',
        ]);

        $role = TeamRole::create($data);
        return $this->success($role, 201);
    }

    /**
     * Update an existing team role.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $role = TeamRole::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->error('TeamRole not found', 404);
        }

        $data = $request->validate([
            'name' => "sometimes|required|string|unique:team_role,name,{$id}",
        ]);

        $role->update($data);
        return $this->success($role);
    }

    /**
     * Delete a team role.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = TeamRole::destroy($id);
        if (! $deleted) {
            return $this->error('TeamRole not found or could not be deleted', 404);
        }
        return $this->success(null, 204);
    }
}
