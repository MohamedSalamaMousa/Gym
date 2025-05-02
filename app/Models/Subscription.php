<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'service_id', 'remaining_sessions', 'start_date', 'remaining_invitions', 'end_date', 'status', 'renewed_from', 'is_individual', 'captain_id', 'remaining_freeze_days', 'captain_percentage'];
    public function updateStatus()
    {
        // Check if the subscription has expired
        $isExpired = $this->remaining_sessions <= 0 || Carbon::parse($this->end_date)->isPast();

        if ($isExpired && $this->status !== 'expired') {
            $this->status = 'expired'; // Mark as expired if it's not already expired
        } elseif (!$isExpired && $this->status !== 'active') {
            $this->status = 'active'; // Mark as active if it's not already active
        }

        // Save the changes only if the status has changed
        if ($this->isDirty('status')) {
            $this->save(); // Save the changes
        }
    }


    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function previousSubscription()
    {
        return $this->belongsTo(Subscription::class, 'renewed_from');
    }

    public function renewSubscription()
    {
        return self::create([
            'member_id' => $this->member_id,
            'service_id' => $this->service_id,
            'remaining_sessions' => $this->service->session_count,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'status' => 'active',
            'renewed_from' => $this->id,
        ]);
    }
    public function captain()
    {
        return $this->belongsTo(Captain::class);
    }
    public function payments()
    {
        return $this->hasMany(SubscriptionPayment::class);
    }

    public function getPaidAmountAttribute()
    {
        return $this->payments()->sum('paid_amount'); // مجموع المدفوعات
    }
    public function captainWallet()
    {
        return $this->hasOne(CaptainWallet::class);
    }
}
