<?php
namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;
use Session;
use Gloudemans\Shoppingcart\Facades\Cart;
class WebstoreController extends Controller
{
    public function index()
    {
        
        $products = Product::all();
        return view('home')->with('products', $products);
    }

    public function filter()
    {
        
        $data = request()->validate([
            'maximum_price' => 'numeric',
            'category' => 'required'
        ]);
        // dd($data);
        Session::put('category', $data['category']);
        Session::put('maximum_price', $data['maximum_price']);
        $products = Product::where('category','=', $data['category'])->where('price','<', (int)$data['maximum_price'])->get();
        return view('home')->with('products', $products);
    }

    public function addToCart(Product $product )
    {
        Cart::add($product->id, $product->name, 1, $product->price);
        $products = Product::where('category','=',Session::get('category') )->where('price','<', Session::get('maximum_price'))->get();
        return view('home')->with('products', $products);
    }
  
    public function removeProductFromCart($productId)
    {
        Cart::remove($productId);
        $products = Product::where('category','=',Session::get('category') )->where('price','<', Session::get('maximum_price'))->get();
        return view('home')->with('products', $products);
    }
    
    public function destroyCart()
    {
        Cart::destroy();
        $products = Product::where('category','=',Session::get('category') )->where('price','<', Session::get('maximum_price'))->get();
        return view('home')->with('products', $products);
    }   
}