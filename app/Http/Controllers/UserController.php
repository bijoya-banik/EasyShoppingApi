<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    
    public function register(Request $request)
    {
        $user = User::create([
            'firstName' => $request->get('firstName'),
            'lastName' => $request->get('lastName'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'password' => Hash::make($request->get('password')),
            'userType' =>"Buyer",
            'profilePicture' => "https://drive.google.com/file/d/10U5_6FCrNF0ZkdfV4atJgBJ_7jdQkAjy/view",
            'deviceToken' => "",
        ]);

       return response()->json(
        [           
        'success' => true,
        'message'=>"User Created",
        'user' => $user
       
        ]
    );
    }


    public function login(Request $request)
    {
        $credentials = $request->only('phone', 'password',);

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(

                     [
                        'error' => 'invalid_credentials'
                        ]
                    , 400);
            }
        } catch (JWTException $e) {
            return response()->json(
                [
                    'error' => 'could_not_create_token'
                ], 500);
        }
        $user = Auth::user();

      

         $id = $user->id; 

         User::where('id',$id)->update([

            'deviceToken'=>$request->get('deviceToken'),           
         ]); 

  


        return response()->json(
            [           
            'success' => true,
            'user'=>$user,
            'token'=> $token, ]
        );
    }

    public function editUser(Request $request){   
       
        $user = JWTAuth::parseToken()->authenticate();
        $id = $request->id; 
        

        $user = User::where('id',$id)->update([

            'firstName' => $request->get('firstName'),
            'lastName' => $request->get('lastName'),
            
         ]); 
      
     

       return response()->json(
           [           
           'success' => true,
           'message'=>"Edited Successfully",
           'user' => $user
          
           ]
       );
   }

   public function editPassword(Request $request){   
       
    $user = JWTAuth::parseToken()->authenticate();
    $id = $request->id; 
    

    $user =
     User::where('id',$id)->update([

        'password' => Hash::make($request->get('password')),
       
     ]); 
  
 

   return response()->json(
       [           
       'success' => true,
       'message'=>"Edited Successfully",
       'user' => $user
      
       ]
   );
}

public function logout(Request $request){
       

    $id = $request->id; 

    User::where('id',$id)->update([

       'deviceToken'=>null,           
    ]); 

   return response()->json(
       [           
       'success' => true,
      
       ]
   );
}
}
