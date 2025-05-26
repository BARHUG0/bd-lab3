<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamContest extends Model
{
    protected $table    = 'team_contests';
    public $timestamps  = false;
    protected $fillable = ['team_id', 'contest_id'];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class, 'contest_id');
    }
}
