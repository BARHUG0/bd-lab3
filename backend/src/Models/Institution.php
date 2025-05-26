<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Institution extends Model
{
    protected $table    = 'institution';
    public $timestamps  = false;
    protected $fillable = ['name'];

    /**
     * Users affiliated with this institution.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'institution_id');
    }

    /**
     * Teams associated with this institution.
     */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class, 'institution_id');
    }
}
