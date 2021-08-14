<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetail;
use App\Models\User;

class Order extends Model
{
    use HasFactory;
    protected $fillable =[
       'userId',
       'address',
       'phone',
       'shippingPrice',
       'subTotal',
       'grandTotal',
       'paymentType',
       'status',
       
       
];

public function orderDetail(){ 
              
    return $this->hasMany('App\Models\OrderDetail','order_id');
} 
public function user(){ 
              
    return $this->belongsTo('App\Models\User','userId');
} 
}
