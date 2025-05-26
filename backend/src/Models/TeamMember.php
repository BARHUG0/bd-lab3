<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMember extends Model
{
    protected $table    = 'team_members';
    public $timestamps  = false;
    protected $fillable = ['user_id', 'team_id', 'team_role_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(TeamRole::class, 'team_role_id');
    }
}
