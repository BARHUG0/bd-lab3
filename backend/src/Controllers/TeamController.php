<?php
// File: src/Controllers/TeamController.php
namespace App\Controllers;

use App\Models\Team;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamController extends BaseController
{
    public function __construct(ResponseFactory $response)
    {
        parent::__construct($response);
    }

    /**
     * List all teams with related data.
     */
    public function index(): JsonResponse
    {
        $teams = Team::with(['status', 'institution', 'users', 'contests'])->get();
        return $this->success($teams);
    }

    /**
     * Show a specific team by ID with related data.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $team = Team::with(['status', 'institution', 'users', 'contests'])->findOrFail($id);
            return $this->success($team);
        } catch (ModelNotFoundException $e) {
            return $this->error('Team not found', 404);
        }
    }

    /**
     * Create a new team.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'status_id'      => 'required|integer|exists:status,id',
            'institution_id' => 'required|integer|exists:institution,id',
            'name'           => 'required|string',
            'has_issues'     => 'boolean',
        ]);

        $team = Team::create($data);
        return $this->success($team, 201);
    }

    /**
     * Update an existing team.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $team = Team::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->error('Team not found', 404);
        }

        $data = $request->validate([
            'name'       => 'sometimes|required|string',
            'has_issues' => 'sometimes|boolean',
        ]);

        $team->update($data);
        return $this->success($team);
    }

    /**
     * Delete a team.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = Team::destroy($id);
        if (! $deleted) {
            return $this->error('Team not found or could not be deleted', 404);
        }
        return $this->success(null, 204);
    }
}
