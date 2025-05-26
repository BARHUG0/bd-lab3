<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    protected $table    = 'team';
    public $timestamps  = false;
    protected $fillable = ['status_id', 'institution_id', 'name', 'has_issues'];

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    public function teamMembers(): HasMany
    {
        return $this->hasMany(TeamMember::class, 'team_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_members', 'team_id', 'user_id');
    }

    public function contests(): BelongsToMany
    {
        return $this->belongsToMany(Contest::class, 'team_contests', 'team_id', 'contest_id');
    }
}
