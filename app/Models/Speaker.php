<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }

    public function sideAdvertisements()
    {
        return $this->belongsToMany(SideAdvertisement::class, 'side_advertisement_speakers');
    }
   public function packages(){
       return $this->belongsToMany(Package::class, 'packages_speaker');
   }


}
