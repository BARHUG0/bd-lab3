<?php
// File: src/Controllers/TeamMemberController.php
namespace App\Controllers;

use App\Models\TeamMember;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamMemberController extends BaseController
{
    public function __construct(ResponseFactory $response)
    {
        parent::__construct($response);
    }

    /**
     * List all team members with related data.
     */
    public function index(): JsonResponse
    {
        $members = TeamMember::with(['user', 'team', 'role'])->get();
        return $this->success($members);
    }

    /**
     * Show a specific team member association by ID.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $member = TeamMember::with(['user', 'team', 'role'])->findOrFail($id);
            return $this->success($member);
        } catch (ModelNotFoundException $e) {
            return $this->error('TeamMember not found', 404);
        }
    }

    /**
     * Create a new team member association.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'user_id'      => 'required|integer|exists:user,id',
            'team_id'      => 'required|integer|exists:team,id',
            'team_role_id' => 'required|integer|exists:team_role,id',
        ]);

        $member = TeamMember::create($data);
        return $this->success($member, 201);
    }

    /**
     * Update an existing team member association.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $member = TeamMember::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->error('TeamMember not found', 404);
        }

        $data = $request->validate([
            'team_role_id' => 'sometimes|required|integer|exists:team_role,id',
        ]);

        $member->update($data);
        return $this->success($member);
    }

    /**
     * Delete a team member association.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = TeamMember::destroy($id);
        if (! $deleted) {
            return $this->error('TeamMember not found or could not be deleted', 404);
        }
        return $this->success(null, 204);
    }
}
