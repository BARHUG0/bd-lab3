<?php
// File: src/Controllers/TeamContestController.php
namespace App\Controllers;

use App\Models\TeamContest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TeamContestController extends BaseController
{
    public function __construct(ResponseFactory $response)
    {
        parent::__construct($response);
    }

    /**
     * List all team-contest associations.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $associations = TeamContest::with(['team', 'contest'])->get();
        return $this->success($associations);
    }

    /**
     * Show a specific association by ID.
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $association = TeamContest::with(['team', 'contest'])->findOrFail($id);
            return $this->success($association);
        } catch (ModelNotFoundException $e) {
            return $this->error('TeamContest association not found', 404);
        }
    }

    /**
     * Create a new team-contest association.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'team_id'    => 'required|integer|exists:team,id',
            'contest_id' => 'required|integer|exists:contest,id',
        ]);

        $association = TeamContest::create($data);
        return $this->success($association, 201);
    }

    /**
     * Update an existing team-contest association.
     */
    public function update(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $association = TeamContest::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->error('TeamContest association not found', 404);
        }

        $data = $request->validate([
            'team_id'    => 'sometimes|required|integer|exists:team,id',
            'contest_id' => 'sometimes|required|integer|exists:contest,id',
        ]);

        $association->update($data);
        return $this->success($association);
    }

    /**
     * Delete a team-contest association.
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        $deleted = TeamContest::destroy($id);
        if (! $deleted) {
            return $this->error('TeamContest association not found or could not be deleted', 404);
        }
        return $this->success(null, 204);
    }
}
