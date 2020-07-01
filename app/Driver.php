<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table="drivers";

    protected $fillable = [
        'name',
        'phone',
        'email',
        'plate_no',
        'status',
        'city',
        'area'
    ];
    protected $hidden=['password','created_at','updated_at'];

    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function pick_up_point()
    {
    	return $this->hasOne(PickupPoint::class);
    }

}
