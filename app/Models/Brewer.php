<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brewer extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function beers()
    {
        return $this->hasMany(Beer::class);
    }
}
