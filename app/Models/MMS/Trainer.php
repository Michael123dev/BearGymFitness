<?php

namespace App\Models\MMS;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $connection   =   'mms';
    protected $guarded      =   ['id'];

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }
}
