<?php
// File: src/Controllers/ContestController.php
namespace App\Controllers;

use App\Models\Contest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ContestController extends BaseController
{
    public function __construct(ResponseFactory $response)
    {
        parent::__construct($response);
    }

    public function index()
    {
        $contests = Contest::all();
        return $this->success($contests);
    }

    public function show($id)
    {
        try {
            $contest = Contest::findOrFail($id);
            return $this->success($contest);
        } catch (ModelNotFoundException $e) {
            return $this->error('Contest not found', 404);
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                    => 'required|string',
            'start_date'              => 'required|date',
            'end_date'                => 'required|date',
            'registration_start_date' => 'required|date',
            'registration_end_date'   => 'required|date',
        ]);
        $contest = Contest::create($data);
        return $this->success($contest, 201);
    }

    public function update(Request $request, $id)
    {
        try {
            $contest = Contest::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->error('Contest not found', 404);
        }

        $data = $request->validate([
            'name'                    => 'sometimes|required|string',
            'start_date'              => 'sometimes|required|date',
            'end_date'                => 'sometimes|required|date',
            'registration_start_date' => 'sometimes|required|date',
            'registration_end_date'   => 'sometimes|required|date',
        ]);
        $contest->update($data);
        return $this->success($contest);
    }

    public function destroy($id)
    {
        if (! Contest::destroy($id)) {
            return $this->error('Contest not found or could not be deleted', 404);
        }
        return $this->success(null, 204);
    }
}
