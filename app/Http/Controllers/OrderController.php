<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; 
use App\Models\OrderDetail; 
use App\Models\Product; 
use App\Models\User; 
class OrderController extends Controller
{
    public function addOrder(Request $request)
    {

              
        $order = Order::create(                    
            [
                'userId' => $request->userId,
                'address' => $request->address,
                'phone' => $request->phone,
                'shippingPrice' => $request->shippingPrice,
                'subTotal' => $request->subTotal,
                'grandTotal' => $request->grandTotal,
                'paymentType' => $request->paymentType,
                //'orderItems' => $request->orderItems,
                'status' => 'Pending',
            ]     
          
        ); 
      
      
        $item=[];
      
       
        $cartItem = [
            ['productId'=>11,'quantity'=>1]
          //  ['productId'=>4,'quantity'=>1]
        ];
       // foreach ($request->orderItems as  $value) {
        foreach ($cartItem as  $value) {

            $ob = [
                'productId' => $value['productId'],
                'order_id' => $order->id,
                'userId' => $order->userId,  
                'quantity' => $value['quantity'],
            ];

           
           
            array_push($item,$ob);

            $product =  Product::where('id', '=', $value['productId'])->get();
       

            foreach ($product as $p) {

                Product::where('id',$value['productId'])->update([         
                    'stock'=>$p['stock']-1,
                ]); 
            }

            
       

        //   return response()->json([
        //     'success'=>true,
        //     'msg'=>$product
            
        // ],200);

        }

       $orders= OrderDetail::insert($item);
  
      
        $name = User::where('id',$order->userId)->value('firstName');
        $notification = $this->sendPush(1, $name);
    

        return response()->json([

            'success' => true,        
            'data' => $orders
                
        ]);
    } 



    public function showOrders(){   
        
        $order =  Order::with('orderDetail.product.category','user')-> get();
        return response()->json([
            'success'=>true,
            'order'=>$order,
        
            ]);
    }

    public function showOrdersType(Request $request){   
        
        $value  = $request->value;

        $order =  Order::where('status','=', "$value" )->with('orderDetail.product.category','user')->get();
        return response()->json([
            'success'=>true,
            'Order'=>$order,
        
            ]);
    }

    public function showMyOrders(Request $request){   
        
        $value  = $request->value;

        $order =  Order::where('userId','=', $value )->with('orderDetail.product.category','user')->get();
        return response()->json([
            'success'=>true,
            'Order'=>$order,
        
            ]);
    }


    public function editOrderStatus(Request $request){


        $id = $request->id;

        if ( Order::find( $id ) === null ) {

            return response()->json([
                'success'=>false,
                'msg'=>"Order does not exist",
                
            ],200);
        }
        else{
        

            Order::where('id',$id)->update([

                'status' => $request->status,
                
            ]); 

            $idUser = Order::where('id',$id)->value('userId');
            $notification = $this->sendPushStatus(1,$request->status, $idUser);
    
            return response()->json([
                'success'=>true,
                'msg'=>"Updated Successfully",
                
            ],200);
        }
       
    }


    public function sendPush($id, $name){
        $ids[0] = User::where('id',$id)->value('deviceToken');
       // $notification = $data;
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array (
                'registration_ids' => $ids,
                'data' => array (
                        'title' => "New Message",
                        "message" => "data",// $data,
                        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                ),
                'notification' => array (
                        'title' => "New Order",
                        "body" =>"Order from $name",                 
                        "sound" => true, 
                        "badge" => 1,
                ),
                'time_to_live' => 6000,
        );
        $fields = json_encode ( $fields );
        $headers = array (
                'Authorization: key=' ."AAAAOXtoDPo:APA91bF7l30uoRQ9dWUN8GGnm7lpLDZUaAXjQUhD1hGSrzdvFB09DflEo4TvF22tWpmRGKUsh-T8ZmqglrZPTu1ZhnI3QH89g2BjFkOHBfGC1EKPvN_PZkmcRWLtBEXy8E2xsPK3rwRS",// "AAAABj6MfPU:APA91bGcUQoIeAMfUfrb7dka-Uk2KFLjTCg3Vbyeg-dB0iUq5oowssu-VgBLIFEcZkVmtpAC4drKpxMdkbXAtdwEh9-uvq-GEBEFj7f4D5G4UofjhwoMF41eQg-c9ib2fVxxw1700SYH",
                'Content-Type: application/json'
        );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        if($result){
            return $result;
        }
    }


    public function sendPushStatus($id, $status,$order_id){
        $ids[0] = User::where('id',$id)->value('deviceToken');
       // $notification = $data;
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array (
                'registration_ids' => $ids,
                'data' => array (
                        'title' => "New Message",
                        "message" => "data",// $data,
                        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                ),
                'notification' => array (
                        'title' => "Order status updated",
                        "body" =>"Order no $order_id updated to $status",                 
                        "sound" => true, 
                        "badge" => 1,
                ),
                'time_to_live' => 6000,
        );
        $fields = json_encode ( $fields );
        $headers = array (
                'Authorization: key=' ."AAAAOXtoDPo:APA91bF7l30uoRQ9dWUN8GGnm7lpLDZUaAXjQUhD1hGSrzdvFB09DflEo4TvF22tWpmRGKUsh-T8ZmqglrZPTu1ZhnI3QH89g2BjFkOHBfGC1EKPvN_PZkmcRWLtBEXy8E2xsPK3rwRS",// "AAAABj6MfPU:APA91bGcUQoIeAMfUfrb7dka-Uk2KFLjTCg3Vbyeg-dB0iUq5oowssu-VgBLIFEcZkVmtpAC4drKpxMdkbXAtdwEh9-uvq-GEBEFj7f4D5G4UofjhwoMF41eQg-c9ib2fVxxw1700SYH",
                'Content-Type: application/json'
        );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        if($result){
            return $result;
        }
    }

}
