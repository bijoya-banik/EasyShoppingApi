<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function addProduct(Request $request){
     
        
         $discount_price = ($request->price * $request->discount)/100;
         $total_price = $request->price  - $discount_price;
        
         $product = Product::create(
            [
                'productName'=>$request->productName,
                'productImage'=>$request->productImage,
                'description'=>$request->description,
                'price'=>$request->price,
                'discount'=>$request->discount,
                'discountPrice'=>$total_price,
                'categoryId'=>$request->categoryId,
                'stock'=>$request->stock,
        
            ]
            
        );

        return response()->json([       
            'success'=>true,
            'Product'=>$product,
                   
        ]);
    }

    public function showAllProduct(){   
        
        $product =  Product::with('category')->get();
        return response()->json([
            'success'=>true,
            'Product'=>$product,
        
            ]);
    }


    public function showOfferProduct(){   
        
        $product =  Product::where('discount', '>', 0)->with('category')->get();
        return response()->json([
            'success'=>true,
            'Product'=>$product,
        
            ]);
    }
    public function showAvailableProduct(){   
        
        $product =  Product::where('stock', '=', 1)->with('category')->get();
        return response()->json([
            'success'=>true,
            'Product'=>$product,
        
            ]);
    }
    public function showStockOutProduct(){   
        
        $product =  Product::where('stock', '=', 0)->with('category')->get();
        return response()->json([
            'success'=>true,
            'Product'=>$product,
        
            ]);
    }
    public function showProductsByCategory(Request $request){   
        
        $categoryId  = $request->categoryId;

        $product =  Product::where('categoryId',$categoryId )->with('category')->get();
        return response()->json([
            'success'=>true,
            'Product'=>$product,
        
            ]);
    }
    
    public function searchProduct(Request $request){   
        
        $value  = $request->value;

        $product =  Product::where('productName','LIKE', "%{$value}%" )->with('category')->get();
        return response()->json([
            'success'=>true,
            'Product'=>$product,
        
            ]);
    }
 

    
    public function editProduct(Request $request){


        $id = $request->id;

        if ( Product::find( $id ) === null ) {

            return response()->json([
                'success'=>false,
                'msg'=>"Product does not exist",
                
            ],200);
        }
        else{

            $discount_price = ($request->price * $request->discount)/100;
            $total_price = $request->price  - $discount_price;

            Product::where('id',$id)->update([

                'productName'=>$request->productName,
                'productImage'=>$request->productImage,
                'description'=>$request->description,
                'price'=>$request->price,
                'discount'=>$request->discount,
                'discountPrice'=>$total_price,
                'categoryId'=>$request->categoryId,
                'stock'=>$request->stock
            ]); 
            $product =  Product::where('id',$id)->with('category')->get();
    
            return response()->json([
                'success'=>true,
                'msg'=>"Updated Successfully",
                'product' =>$product
                
            ],200);
        }
       
    }


    public function deleteProduct(Request $request){

        $id  = $request->id;
        if ( Product::find( $id ) === null ) {

            return response()->json([
                'success'=>false,
                
            ],200);
        }
        else{
        Product::where('id',$id)->delete();


        return response()->json([
            'msg'=>"Deleted successfully"
        ]);
        }



    }
}
