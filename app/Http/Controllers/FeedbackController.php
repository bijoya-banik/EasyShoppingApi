<?php

namespace App\Http\Controllers;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function addFeed(Request $request){
     
        
        $feedback = Feedback::create(
            [
                'userId'=>$request->userId,
                'location'=>$request->location,
                'file'=>$request->file,
                'bank_details'=>$request->bank_details,
                'contact_details'=>$request->contact_details,
            ]
            
        );

        return response()->json([       
            'success'=>true,
            'data'=>$feedback,
                   
        ]);
    }
}
