<?php

namespace App\Models\MMS;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $connection   =   'mms';
    protected $guarded      =   ['id'];
    public $timestamps      =   false;

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function setPackageNameAttribute($value)
    {
        $this->attributes['package_name'] = strtoupper($value);
    }
}
