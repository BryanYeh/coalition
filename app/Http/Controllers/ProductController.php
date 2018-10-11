<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Storage;

class ProductController extends Controller
{
    //pass products to default view
    public function index()
    {
        $products = null;
        if(Storage::exists('products.json')){
            $products = json_decode(Storage::get('products.json'));
        }
        return view('index',['products'=>$products]);
    }

    //process post
    public function process(Request $request)
    {
        $name = $request->productName;
        $qty = $request->quantity;
        $price = $request->price;

        //data validation
        $validatedData = $request->validate([
            'productName' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|regex:/[0-9]*\.[0-9]{2}$/u'
        ]);
        //get date and calculate total
        $date = Carbon::now()->toDateTimeString();
        $total = $price * $qty;
        
        //put into array
        $product = array('name'=>$name,'qty'=>$qty,'price'=>$price,'date'=>$date,'total'=>$total);

        //if file doesnt exist, start new json otherwise combine
        if(Storage::exists('products.json')){
            $products = json_decode(Storage::get('products.json'));
            if(!is_array($products)) 
                $products = [$products];
            $data = array_merge($products,[json_decode(json_encode($product))]);
        }
        else{
            $data = [$product];
        }

        //save into json file
        $newProducts = json_encode($data);
        Storage::put('products.json', $newProducts);

        //send list back
        return json_decode($newProducts);
    }
}
