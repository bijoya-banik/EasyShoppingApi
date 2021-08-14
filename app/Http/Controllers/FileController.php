<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function uploadImage (Request $request){ 
  
                   
        $pic= $request->photo->hashName();        
       // $path =   
        request()->file('photo')->move(public_path("/uploads"), $pic);                     
       // $photoUrl  = url('/uploads',$pic);
        $photoUrl = '/uploads/'.$pic;
        return response()->json([
            'imageUrl'=> $photoUrl
            //'path'=> $path
        ],200);
  

    
}
}
