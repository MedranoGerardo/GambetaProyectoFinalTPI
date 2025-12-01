<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedTime extends Model
{
    protected $fillable = [
        'field_id','date','start_time','end_time','reason'
    ];

    public function field(){
        return $this->belongsTo(Field::class);
    }
}
