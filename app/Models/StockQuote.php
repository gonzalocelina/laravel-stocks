<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockQuote extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'symbol', 'high', 'low', 'price',
    ];
}
