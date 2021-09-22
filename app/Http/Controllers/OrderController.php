<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OrderResource::collection(Order::with('orderItems')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $order = new Order();
            $order->order_date = $request->input('order_date');
            $order->order_status = $request->input('order_status');
            $order->promotion_code = $request->input('promotion_code');
            $order->customer_id = $request->input('customer_id');

            $order->save();

            $lineItems = [];

            foreach($request->input('products') as $item){
                
                $product = Product::find($item['product_id']);
                
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $product->id;
                $orderItem->unit_price = $product->minimun_price;
                $orderItem->quantity = $item['quantity'];

                $orderItem->save();

                $lineItems[] = [
                    'name' => $product->name,
                    'amount' => $item['quantity'] * $product->minimun_price,
                    'currency' => $product->price_currency
                ];
            }

            $result = [
                'order' => $order,
                'payment_method_types' => ['card'],
                'line_items' => $lineItems
            ];

            return response($result, Response::HTTP_OK);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response([
                'error' => $e->getMessage()
            ],400);
        }
    }
}
