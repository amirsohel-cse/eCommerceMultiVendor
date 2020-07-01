<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=[
        'payment_status',
        'payment_details',
        'payment_type',
        'grand_total',
    ];
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function driver(){
     return $this->belongsTo(Driver::class);
    }
    public function pickup_point()
    {
        return $this->belongsTo(PickupPoint::class);
    }
}
