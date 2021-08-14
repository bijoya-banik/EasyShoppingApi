<?php

namespace App\Http\Controllers;
use App\Models\Suggestion;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function addSuggestion(Request $request){
     
        
        $suggestion = Suggestion::create(
            [
                'userId'=>$request->userId,
                'message'=>$request->message,
            ]
            
        );

        return response()->json([       
            'success'=>true,
            'data'=>$suggestion,
                   
        ]);
    }


}
