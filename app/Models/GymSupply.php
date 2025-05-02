<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymSupply extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_name',
        'quantity',
        'unit_price',
        'total_price',
        'purchase_date',
        'created_by',
        'updated_by',
    ];
    public function Createdby()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}