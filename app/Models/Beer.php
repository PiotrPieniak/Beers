<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beer extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function brewer()
    {
        return $this->belongsTo(Brewer::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
