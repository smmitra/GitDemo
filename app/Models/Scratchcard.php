<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scratchcard extends Model
{
    //

    protected $fillable = [
    'batch_no',
    'card_number',
    'card_price',
    'is_prize_eligible',
    'prize_amount',
    'month',
];

}
