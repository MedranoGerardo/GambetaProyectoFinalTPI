<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
        protected $fillable = [
            'name','type','price_per_hour','image','is_active'
        ];

        public function reservations(){
            return $this->hasMany(Reservation::class);
        }

        public function blockedTimes(){
            return $this->hasMany(BlockedTime::class);
        }
}