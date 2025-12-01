<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
        protected $fillable = [
            'client_id','field_id','user_id',
            'date','start_time','end_time',
            'total_price','status'
        ];

        public function client(){
            return $this->belongsTo(Client::class);
        }

        public function field(){
            return $this->belongsTo(Field::class);
        }

        public function user(){
            return $this->belongsTo(User::class);
        }

        public function payments(){
            return $this->hasMany(Payment::class);
        }
}