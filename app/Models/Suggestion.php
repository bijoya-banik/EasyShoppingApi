<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;
    protected $fillable =['userId','message'];

    public function user(){ 
              
        return $this->belongsTo('App\Models\User','userId');
    } 
}
