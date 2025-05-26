<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeamRole extends Model
{
    protected $table    = 'team_role';
    public $timestamps  = false;
    protected $fillable = ['name'];

    /**
     * Team members assigned this role.
     */
    public function teamMembers(): HasMany
    {
        return $this->hasMany(TeamMember::class, 'team_role_id');
    }
}
