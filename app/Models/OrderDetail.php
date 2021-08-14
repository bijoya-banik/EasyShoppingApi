<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class OrderDetail extends Model
{
    
    protected $fillable =[
        'order_id',
        'userId',
        'productId',
        'quantity',
 ];

 public function product(){ 
              
    return $this->belongsTo('App\Models\Product','productId','id');
} 
}
