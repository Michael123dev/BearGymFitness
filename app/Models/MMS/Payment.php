<?php

namespace App\Models\MMS;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $connection = 'mms';
    protected $guarded = ['id'];


    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}
