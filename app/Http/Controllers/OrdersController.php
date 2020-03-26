<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use DB;
use Session;
use Cookie;
use Illuminate\Http\Request;


class OrdersController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        //get orders
        $orders = DB::table('order_info')
                ->get();

        return view("orders.index")->with('orders', $orders);
    }

    public function show($id) {
        
        $items = DB::table('items')
                    ->join('items_sold', 'items.id', '=', 'items_sold.item_id')
                    ->select('items.title', 'items.price', 'items_sold.quantity', 'items_sold.item_id')
                    ->where('items_sold.order_id', $id)
                    ->get();

        $data = DB::table('order_info')
                    ->select('first_name', 'last_name', 'phone', 'email')
                    ->where('id', $id)
                    ->get();
        
        //get subtotal
        $prices = DB::table('items_sold')
                    ->select('price', 'quantity')
                    ->where('order_id', $id)
                    ->get();

        $subtotal = 0.0;
        foreach ($prices as $price) {
            $fullprice = $price->price * $price->quantity;
            $subtotal += $fullprice;
        }
             
        return view("orders.show")->with('items', $items)->with('order_id', $id)->with('data', $data)->with('subtotal', $subtotal);
    }
}