<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use Carbon\Carbon;
use DB;
use Session;
use Cookie;
use Illuminate\Http\Request;

class PublicController extends Controller {
    
    //gets all products
    public function getProducts(Request $request) {
        $session_id = Session::getId();
        $ip_address = $request->ip();
        Session::put('ipAddress', $ip_address);

        $categories = Category::orderBy('created_at', 'desc')->get();
        $items = Item::orderBy('created_at', 'desc')->get();
        return view("public.product")->withCategories($categories)->withItems($items);
    }

    //specfic item
    public function getItem(Request $request, $id) {
        $session_id = Session::getId();
        $ip_address = $request->ip();
        Session::put('ipAddress', $ip_address);

        $item = Item::find($id);
        return view("public.item")->with('item', $item);
    }

    //items dependent on category
    public function getCategory(Request $request, $id) {
        $session_id = Session::getId();
        $ip_address = $request->ip();
        // $ip_address = Request::ip();
        Session::put('ipAddress', $ip_address);

        //get the category requested, all categories, and items
        $category = Category::find($id);
        $categories = Category::orderBy('created_at', 'desc')->get();
        $catItems = Item::where('category_id', $id)->get();
        return view("public.category")->withCategories($categories)->withItems($catItems)->with('category', $category);
    }

    public function getCart(Request $request) {
        $session_id = Session::getId();
        $ip_address = $request->ip();
        Session::put('ipAddress', $ip_address);

        //get subtotal
        $prices = DB::table('items')
                ->join('shopping_cart', 'items.id', '=', 'shopping_cart.item_id')
                ->select('items.price', 'shopping_cart.quantity')
                ->where('shopping_cart.session_id', $session_id)
                ->get();

        $subtotal = 0.0;
        foreach ($prices as $price) {
            $fullprice = $price->price * $price->quantity;
            $subtotal += $fullprice;
        }

        //get items for shopping cart
        $items = DB::table('items')
                ->join('shopping_cart', 'items.id', '=', 'shopping_cart.item_id')
                ->select('items.title', 'items.price', 'items.id', 'shopping_cart.quantity')
                ->where('shopping_cart.session_id', $session_id)
                ->get();
        
        return view("public.cart")->withItems($items)->with('subtotal', $subtotal);
    }

    public function add_to_cart(Request $request, $id) {
        $session_id = Session::getId();
        $ip_address = $request->ip();
        Session::put('ipAddress', $ip_address);
        Session::push('item', $id);

        $date = Carbon::now();
        //insert into db
        $data = array('item_id'=>$id, "session_id"=>$session_id, "ip_address"=>$ip_address, "quantity"=>1, "created_at"=>$date, "updated_at"=>$date);
        DB::table('shopping_cart')->insert($data);
        
        //redirect
        return redirect()->route('cart');
    }

    public function update_cart(Request $request, $id) {
        $session_id = Session::getId();
        $ip_address = $request->ip();
        Session::put('ipAddress', $ip_address);

        $date = Carbon::now();
        // get requested quantity and max quantity
        $quantity = $request->quantity;
        $max_quantity = DB::table('items')
                ->where('id', $id)
                ->value('quantity');
        if ($quantity <= $max_quantity) {
            // insert into db
            DB::table('shopping_cart')
                ->where([
                    ['item_id', $id],
                    ['session_id', $session_id]
                ])
                ->update(['quantity'=>$quantity, 'updated_at'=>$date]);

            Session::flash('success','Quantity updated.');
        } 
        else {
            Session::flash('failed', 'Quantity too large.');
        }

        //redirect
        return redirect()->route('cart');
    }

    public function remove_item(Request $request, $id) {
        $session_id = Session::getId();
        $ip_address = $request->ip();
        Session::put('ipAddress', $ip_address);

        DB::table('shopping_cart')
            ->where([
                ['item_id', $id],
                ['session_id', $session_id]
            ])
            ->delete();

        Session::flash('success','Item deleted.');

        //redirect
        return redirect()->route('cart');
    }

    public function check_order(Request $request) {
        if(!Session::has('ipAddress')) {
            return redirect()->route('products');
        }
        $session_id = Session::getId();
        $ip_address = $request->ip();
        Session::put('ipAddress', $ip_address);

        $this->validate($request, ['first_name'=>'required|string|max:255',
                                   'last_name'=>'required|string|max:225',
                                   'phone'=>'required|string|max:100',
                                   'email'=>'required|string|email']);

        $date = Carbon::now();
        //insert into db
        $data = array('session_id'=>$session_id, 
                        "ip_address"=>$ip_address, 
                        "first_name"=>$request->first_name, 
                        "last_name"=>$request->last_name, 
                        "phone"=>$request->phone, 
                        "email"=>$request->email,
                        "created_at"=>$date, 
                        "updated_at"=>$date);
        DB::table('order_info')->insert($data);

        //get order_id
        $order_ids = DB::table('order_info')
                ->select('id')
                ->where('session_id', $session_id)
                ->take(1)
                ->get();
        
        foreach ($order_ids as $id) {
            $order_id = $id->id;
        }

        $items = DB::table('items')
                    ->join('shopping_cart', 'items.id', '=', 'shopping_cart.item_id')
                    ->select('items.title', 'items.price', 'shopping_cart.quantity', 'shopping_cart.item_id')
                    ->where('shopping_cart.session_id', $session_id)
                    ->get();

        //insert into db
        foreach($items as $item) {
            $items_data = array("order_id"=>$order_id, 
                            "item_id"=>$item->item_id, 
                            "price"=>$item->price, 
                            "quantity"=>$item->quantity,
                            "created_at"=>$date, 
                            "updated_at"=>$date);
            DB::table('items_sold')->insert($items_data);
        }

        //get subtotal
        $prices = DB::table('items')
                ->join('shopping_cart', 'items.id', '=', 'shopping_cart.item_id')
                ->select('items.price', 'shopping_cart.quantity')
                ->where('shopping_cart.session_id', $session_id)
                ->get();

        $subtotal = 0.0;
        foreach ($prices as $price) {
            $fullprice = $price->price * $price->quantity;
            $subtotal += $fullprice;
        }

        // the ::flush() wouldn't work to unset the session 
        Session::forget('ipAddress');
        $value = session('ipAddress');
        Session::regenerate();
       
        return view("public.thankyou")->withItems($items)->with('data', $data)->with('subtotal', $subtotal)->with('order_id', $order_id);
    }
}