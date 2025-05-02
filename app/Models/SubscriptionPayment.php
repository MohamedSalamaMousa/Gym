<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'subscription_id',
        'paid_amount',
        'paid_at',
    ];
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
