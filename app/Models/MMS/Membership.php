<?php

namespace App\Models\MMS;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $connection = 'mms';

    protected $guarded = ['id'];

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
