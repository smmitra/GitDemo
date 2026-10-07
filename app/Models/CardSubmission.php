<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardSubmission extends Model
{
    protected $table = 'card_submissions';
    public $timestamps = false;
    protected $primaryKey = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'id',
        'card_number',
        'phone',
        'otp',
        'otp_verified',
        'otp_created_at',
        'otp_verified_at',
        'is_winner',
        'prize_amount',
        'admin_whatsapp_sent',
        'created_at',
        'updated_at',
    ];

}
