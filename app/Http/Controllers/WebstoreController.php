<?php
namespace App\Http\Controllers;
use App\Product;
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
        $products = Product::where('category','=', $data['category'])->where('price','<', (int)$data['maximum_price'])->get();
        return view('home')->with('products', $products);
    }

    public function addToCart(Product $product)
    {
        Cart::add($product->id, $product->name, 1, $product->price);
        return redirect('/home');
    }
  
    public function removeProductFromCart($productId)
    {
        Cart::remove($productId);
        return redirect('/home');
    }
    
    public function destroyCart()
    {
        Cart::destroy();
        return redirect('/home');
    }   
}