<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $table    = 'user';
    public $timestamps  = false;
    protected $fillable = [
        'title_id', 'us_tshirt_size_id', 'home_country_id', 'residenc_country_id',
        'institution_id', 'passport_country', 'first_name', 'last_name', 'local_name',
        'badge_name', 'certificate_name', 'sex', 'date_of_birth', 'home_town',
        'home_state', 'job_title', 'company', 'special_needs', 'secondary_email',
        'inform_other_contestants', 'include_email', 'open_to_employment_opportunities',
        'area_of_study', 'degree_persued', 'start_of_bachelor_degree',
        'expected_graduation_date', 'total_sememesters_completed', 'phone', 'mobile',
        'home_airport_code', 'emergency_phone', 'emergency_contact_name', 'street',
        'street_line_2', 'street_line_3', 'city', 'state', 'postal_code',
        'profile_picture_url', 'resume_url', 'twitter_username', 'twitter_hashtag',
        'facebook_page', 'top_coder', 'code_forces', 'linkedin', 'social_info',
    ];

    public function title(): BelongsTo
    {
        return $this->belongsTo(Title::class, 'title_id');
    }

    public function tshirtSize(): BelongsTo
    {
        return $this->belongsTo(UsTshirtSize::class, 'us_tshirt_size_id');
    }

    public function homeCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'home_country_id');
    }

    public function residenceCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'residenc_country_id');
    }

    public function passportCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'passport_country');
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    /**
     * Team memberships for this user.
     */
    public function teamMembers(): HasMany
    {
        return $this->hasMany(TeamMember::class, 'user_id');
    }

    /**
     * Teams this user belongs to.
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_members', 'user_id', 'team_id');
    }
}
