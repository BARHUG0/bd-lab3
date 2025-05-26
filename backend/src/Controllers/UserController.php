<?php
// File: src/Controllers/UserController.php
namespace App\Controllers;

use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function __construct(ResponseFactory $response)
    {
        parent::__construct($response);
    }

    /**
     * List all users with related data.
     */
    public function index(): JsonResponse
    {
        $users = User::with([
            'title',
            'tshirtSize',
            'homeCountry',
            'residenceCountry',
            'passportCountry',
            'institution',
            'teams',
        ])->get();
        return $this->success($users);
    }

    /**
     * Show a specific user by ID with related data.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $user = User::with([
                'title',
                'tshirtSize',
                'homeCountry',
                'residenceCountry',
                'passportCountry',
                'institution',
                'teams',
            ])->findOrFail($id);
            return $this->success($user);
        } catch (ModelNotFoundException $e) {
            return $this->error('User not found', 404);
        }
    }

    /**
     * Create a new user with full validation.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title_id'                         => 'required|integer|exists:title,id',
            'us_tshirt_size_id'                => 'required|integer|exists:us_tshirt_size,id',
            'home_country_id'                  => 'required|integer|exists:country,id',
            'residenc_country_id'              => 'required|integer|exists:country,id',
            'institution_id'                   => 'required|integer|exists:institution,id',
            'passport_country'                 => 'required|integer|exists:country,id',
            'first_name'                       => 'required|string|max:128',
            'last_name'                        => 'required|string|max:128',
            'local_name'                       => 'nullable|string|max:128',
            'badge_name'                       => 'nullable|string|max:128',
            'certificate_name'                 => 'nullable|string|max:128',
            'sex'                              => 'nullable|in:M,F',
            'date_of_birth'                    => 'nullable|date',
            'home_town'                        => 'nullable|string|max:128',
            'home_state'                       => 'nullable|string|max:128',
            'job_title'                        => 'nullable|string|max:64',
            'company'                          => 'nullable|string|max:64',
            'special_needs'                    => 'nullable|string',
            'secondary_email'                  => 'nullable|email|max:255',
            'inform_other_contestants'         => 'boolean',
            'include_email'                    => 'boolean',
            'open_to_employment_opportunities' => 'boolean',
            'area_of_study'                    => 'nullable|string|max:128',
            'degree_persued'                   => 'nullable|string|max:128',
            'start_of_bachelor_degree'         => 'nullable|date',
            'expected_graduation_date'         => 'nullable|date',
            'total_sememesters_completed'      => 'nullable|integer',
            'phone'                            => 'nullable|string|max:15',
            'mobile'                           => 'nullable|string|max:15',
            'home_airport_code'                => 'nullable|string|max:4',
            'emergency_phone'                  => 'nullable|string|max:15',
            'emergency_contact_name'           => 'nullable|string|max:128',
            'street'                           => 'nullable|string|max:255',
            'street_line_2'                    => 'nullable|string|max:255',
            'street_line_3'                    => 'nullable|string|max:255',
            'city'                             => 'nullable|string|max:128',
            'state'                            => 'nullable|string|max:128',
            'postal_code'                      => 'nullable|string|max:8',
            'profile_picture_url'              => 'nullable|url',
            'resume_url'                       => 'nullable|url',
            'twitter_username'                 => 'nullable|string|max:255',
            'twitter_hashtag'                  => 'nullable|string|max:32',
            'facebook_page'                    => 'nullable|url',
            'top_coder'                        => 'nullable|string|max:255',
            'code_forces'                      => 'nullable|string|max:255',
            'linkedin'                         => 'nullable|url',
            'social_info'                      => 'nullable|string',
        ]);

        $user = User::create($data);
        return $this->success($user, 201);
    }

    /**
     * Update an existing user with full validation.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->error('User not found', 404);
        }

        $data = $request->validate([
            'title_id'                         => 'sometimes|required|integer|exists:title,id',
            'us_tshirt_size_id'                => 'sometimes|required|integer|exists:us_tshirt_size,id',
            'home_country_id'                  => 'sometimes|required|integer|exists:country,id',
            'residenc_country_id'              => 'sometimes|required|integer|exists:country,id',
            'institution_id'                   => 'sometimes|required|integer|exists:institution,id',
            'passport_country'                 => 'sometimes|required|integer|exists:country,id',
            'first_name'                       => 'sometimes|required|string|max:128',
            'last_name'                        => 'sometimes|required|string|max:128',
            'local_name'                       => 'sometimes|nullable|string|max:128',
            'badge_name'                       => 'sometimes|nullable|string|max:128',
            'certificate_name'                 => 'sometimes|nullable|string|max:128',
            'sex'                              => 'sometimes|nullable|in:M,F',
            'date_of_birth'                    => 'sometimes|nullable|date',
            'home_town'                        => 'sometimes|nullable|string|max:128',
            'home_state'                       => 'sometimes|nullable|string|max:128',
            'job_title'                        => 'sometimes|nullable|string|max:64',
            'company'                          => 'sometimes|nullable|string|max:64',
            'special_needs'                    => 'sometimes|nullable|string',
            'secondary_email'                  => 'sometimes|nullable|email|max:255',
            'inform_other_contestants'         => 'sometimes|boolean',
            'include_email'                    => 'sometimes|boolean',
            'open_to_employment_opportunities' => 'sometimes|boolean',
            'area_of_study'                    => 'sometimes|nullable|string|max:128',
            'degree_persued'                   => 'sometimes|nullable|string|max:128',
            'start_of_bachelor_degree'         => 'sometimes|nullable|date',
            'expected_graduation_date'         => 'sometimes|nullable|date',
            'total_sememesters_completed'      => 'sometimes|nullable|integer',
            'phone'                            => 'sometimes|nullable|string|max:15',
            'mobile'                           => 'sometimes|nullable|string|max:15',
            'home_airport_code'                => 'sometimes|nullable|string|max:4',
            'emergency_phone'                  => 'sometimes|nullable|string|max:15',
            'emergency_contact_name'           => 'sometimes|nullable|string|max:128',
            'street'                           => 'sometimes|nullable|string|max:255',
            'street_line_2'                    => 'sometimes|nullable|string|max:255',
            'street_line_3'                    => 'sometimes|nullable|string|max:255',
            'city'                             => 'sometimes|nullable|string|max:128',
            'state'                            => 'sometimes|nullable|string|max:128',
            'postal_code'                      => 'sometimes|nullable|string|max:8',
            'profile_picture_url'              => 'sometimes|nullable|url',
            'resume_url'                       => 'sometimes|nullable|url',
            'twitter_username'                 => 'sometimes|nullable|string|max:255',
            'twitter_hashtag'                  => 'sometimes|nullable|string|max:32',
            'facebook_page'                    => 'sometimes|nullable|url',
            'top_coder'                        => 'sometimes|nullable|string|max:255',
            'code_forces'                      => 'sometimes|nullable|string|max:255',
            'linkedin'                         => 'sometimes|nullable|url',
            'social_info'                      => 'sometimes|nullable|string',
        ]);

        $user->update($data);
        return $this->success($user);
    }

    /**
     * Delete a user.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = User::destroy($id);
        if (! $deleted) {
            return $this->error('User not found or could not be deleted', 404);
        }
        return $this->success(null, 204);
    }
}
