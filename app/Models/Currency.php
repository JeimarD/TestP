<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['name', 'symbol', 'exchange_rate'];

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }
}
