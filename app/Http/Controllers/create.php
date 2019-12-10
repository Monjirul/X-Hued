<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Product;
use File;

class create extends Controller
{
	/**
	 * 
	 */
    public function index()
    {
    	return view('create', ['loggedUser' => session('loggedUser')]);
    }

    public function addToCart(Request $request)
    {
        
        $image = $request->cartCanvas;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = str_random(10).'.'.'jpg';
        File::put('assets/img/' . $imageName, base64_decode($image));

      $p=['id'=>$imageName,'path'=>$imageName,'price'=>$request->Sprice,'tag'=>'','name'=>'','description'=>''];


       
      return view('singleview')->with(['product' => $p, 
                                            'loggedUser' => session('loggedUser')]);
    }


    public function addToSell(Request $request)
    {
      
        $image = $request->SellCanvas;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = str_random(10).'.'.'jpg';
        File::put('assets/img/' . $imageName, base64_decode($image));

      $p=['id'=>'132','path'=>$imageName,'price'=>$request->SellPrice,'tag'=>'','name'=>'','description'=>''];


       
      return view('sell')->with(['product' => $p, 
                        'loggedUser' => session('loggedUser')]);
    }



    public function productForSell(Request $request)
    {
        $p = new Product;
         
        $p->id= $request->hidden_image; 
        $p->price = $request->price;
        $p->path = $request->hidden_image;
        $p->name = "";
        $p->tag = "";
        $p->description = "";
        $p->addedBy = session('loggedUser')->email;
        $p->view = 0;

        $p->save();

        return redirect()->route('gallery');
    }
}
