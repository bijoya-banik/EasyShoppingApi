<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class categoryController extends Controller
{


    public function addCategory(Request $request){
     
        
        $category = Category::create(
            [
                'categoryName'=>$request->categoryName,
                'categoryImage'=>$request->categoryImage,
            ]
            
        );

        return response()->json([       
            'success'=>true,
            'data'=>$category,
                   
        ]);
    }

    public function showAllCategory(){   
        
        $category =  Category::all();
        //$category =  Category::orderBy('updated_at', 'desc')->get();
        return response()->json([
            'success'=>true,
            'category'=>$category,
        
            ]);
    }

    
    public function editCategory(Request $request){


        $id = $request->id;

        if ( Category::find( $id ) === null ) {

            return response()->json([
                'success'=>false,
                'msg'=>"Category does not exist",
                
            ],200);
        }
        else{
            Category::where('id',$id)->update([

                'categoryName'=>$request->categoryName,
                'categoryImage'=>$request->categoryImage,
            ]); 
    
            return response()->json([
                'success'=>true,
                'msg'=>"Updated Successfully",
                'id'=>$request['id'],
                'categoryName'=>$request['categoryName'],
                'categoryImage'=>$request['categoryImage'],
                
            ],200);
        }
       
    }


    public function deleteCategory(Request $request){

        $id  = $request->id;
        if ( Category::find( $id ) === null ) {

            return response()->json([
                'success'=>false,
                
            ],200);
        }
        else{
        Category::where('id',$id)->delete();


        return response()->json([
            'msg'=>"Deleted successfully"
        ]);
        }



    }
     
}
  