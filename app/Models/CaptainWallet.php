<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaptainWallet extends Model
{
    use HasFactory;
    protected $fillable = [
        'captain_id',
        'amount',
        'type', // 'credit' or 'debit'
        'description',
        'subscription_id'

    ];

    public function captain()
    {
        return $this->belongsTo(Captain::class);
    }
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}