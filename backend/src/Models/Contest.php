<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contest extends Model
{
    protected $table    = 'contest';
    public $timestamps  = false;
    protected $fillable = [
        'name', 'start_date', 'end_date',
        'registration_start_date', 'registration_end_date',
    ];

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_contests', 'contest_id', 'team_id');
    }
}
