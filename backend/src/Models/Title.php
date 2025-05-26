<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Title extends Model
{
    protected $table    = 'title';
    public $timestamps  = false;
    protected $fillable = ['name'];

    /**
     * Users associated with this title.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'title_id');
    }
}
