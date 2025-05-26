<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $table    = 'country';
    public $timestamps  = false;
    protected $fillable = ['name'];

    /**
     * Users born or based in this country.
     */
    public function homeUsers(): HasMany
    {
        return $this->hasMany(User::class, 'home_country_id');
    }

    /**
     * Users residing in this country.
     */
    public function residenceUsers(): HasMany
    {
        return $this->hasMany(User::class, 'residenc_country_id');
    }

    /**
     * Users with passport from this country.
     */
    public function passportUsers(): HasMany
    {
        return $this->hasMany(User::class, 'passport_country');
    }
}
