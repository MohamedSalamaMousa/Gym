<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'whatsapp',
        'emergency_contact',
        'admin_id',
        'uuid',
        'barcode',
        'updated_by',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)->where('status', 'active');
    }
}
