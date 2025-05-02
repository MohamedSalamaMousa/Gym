<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Captain extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'status',
        'price',
        'created_by',
        'updated_by',
        'cleared_by',

    ];
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    public function wallets()
    {
        return $this->hasMany(CaptainWallet::class);
    }
    public function totalWalletBalance()
    {
        // تحديد بداية ونهاية الشهر الحالي
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // جمع رصيد المحفظة لهذا الشهر فقط
        $monthlyWalletTotal = $this->wallets()
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // إضافة السعر الأساسي
        return $monthlyWalletTotal + $this->price;
    }
}
