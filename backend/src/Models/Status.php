<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    protected $table    = 'status';
    public $timestamps  = false;
    protected $fillable = ['name'];

    /**
     * Teams having this status.
     */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class, 'status_id');
    }
}
