<?php
// File: src/Controllers/CountryController.php
namespace App\Controllers;

use App\Models\Country;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends BaseController
{
    public function __construct(ResponseFactory $response)
    {
        parent::__construct($response);
    }

    /**
     * List all countries.
     */
    public function index(): JsonResponse
    {
        $countries = Country::all();
        return $this->success($countries);
    }

    /**
     * Show a specific country by ID.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $country = Country::findOrFail($id);
            return $this->success($country);
        } catch (ModelNotFoundException $e) {
            return $this->error('Country not found', 404);
        }
    }

    /**
     * Create a new country.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|unique:country,name',
        ]);

        $country = Country::create($data);
        return $this->success($country, 201);
    }

    /**
     * Update an existing country.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $country = Country::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->error('Country not found', 404);
        }

        $data = $request->validate([
            'name' => "sometimes|required|string|unique:country,name,{$id}",
        ]);

        $country->update($data);
        return $this->success($country);
    }

    /**
     * Delete a country.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = Country::destroy($id);
        if (! $deleted) {
            return $this->error('Country not found or could not be deleted', 404);
        }
        return $this->success(null, 204);
    }
}
