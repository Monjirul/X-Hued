<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Order;
use App\Carts;
use App\Product;
use PDF;


class cart extends Controller
{
    public function index()
    {
    	return view('cart', ['loggedUser' => session('loggedUser')]);
    }

    public function placeOrder(Request $request)
    {
        $order = new Order;
        
    	$order->oStatus = 'ordered';
    	$order->cartId = $request->cartId;
    	$order->cost = $request->total;
    	$order->cEmail = session('loggedUser')->email;

    	$order->save();


        if(!empty(session("shoppingCart")))
            {
                $total = 0; 

                foreach(session("shoppingCart") as $keys => $values)
                {
                    $p = new Product;
                    if ($p->where('path', $values["item_image"])->first()) 
                    {
                        echo $values["item_image"]."exist";
                    } 
                    else 
                    {
                        $p = new Product;
                        $p->name = "";
                        $p->path = $values["item_image"];
                        $p->price = $values["item_price"];
                        $p->tag = "";
                        $p->description = "";
                        $p->addedBy = session('loggedUser')->email;
                        $p->view = 0;

                        $p->save();
                    }
                    

                    $c = new Carts;
                    $c->cartId = $request->cartId;
                    $c->name = $values["item_image"];
                    $c->quantity = $values["item_quantity"];
                    $c->price = $values["item_price"];
                    $c->total = $values["item_quantity"] * $values["item_price"];

                    $c->save();
                }
            }

        return redirect()->route('singleview.clearCart');
    }

    public function invoicePrint(Request $request)
     {
        $cartId = $request->cartId;

        $c = Carts::where('cartId', $cartId)->get();
        $total = Carts::where('cartId', $cartId)->sum('total');

        

        if ($request->download == true)
        {
            $pdf = PDF::loadView('invoice', ['carts' => $c, 'cartTotal' => $total, 'cartId' => $cartId]);
            return $pdf->download($cartId.'.pdf');
        } 
        else 
        {
            return view('invoice', ['carts' => $c, 'cartTotal' => $total, 'cartId' => $cartId]);
        }
        
     }
}
