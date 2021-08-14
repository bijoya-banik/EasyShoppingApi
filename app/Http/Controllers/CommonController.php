<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class CommonController extends Controller
{
    public function totalData(){   
        
        $totalProductList = Product::all();
        $totalProduct = $totalProductList->count();

        $totalCategoryList = Category::all();
        $totalCategory = $totalCategoryList->count();

        $totalOrderList = Order::all();
        $totalOrder = $totalOrderList->count();
        return response()->json([
            'success'=>true,
            'TotalProduct'=>$totalProduct,
            'TotalCategory'=>$totalCategory,
            'TotalOrder'=>$totalOrder,
        
            ]);
    }

   
}
