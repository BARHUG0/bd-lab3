<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UsTshirtSize extends Model
{
    protected $table    = 'us_tshirt_size';
    public $timestamps  = false;
    protected $fillable = ['name'];

    /**
     * Users associated with this T-shirt size.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'us_tshirt_size_id');
    }
}
