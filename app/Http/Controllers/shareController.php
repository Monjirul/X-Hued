<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Share;
use File;
use App\Love;
use Illuminate\Support\Facades\DB;

class shareController extends Controller
{
    //

    public function index()
    {

        


    	$product = new Product;

    	$p = $product->where('share', '1')->orderBy('id', 'desc')->get();
    	$count = $product->where('share', '1')->count('id');

		//var_dump($count);
    	/*return view('allShares', ['products' => $p, 
    								'countP' => $count, 
    								'loggedUser' => session('loggedUser')]);*/

                               $pLikes =  DB::table('products')
    ->select('products.*', DB::raw('COUNT(loves.pId) as totalLikes'))
    ->where('products.share','=','1')
    ->join('loves', 'products.id', '=', 'loves.pId')
    ->groupBy('loves.pId')
    ->groupBy('products.id')
    ->orderBy('id', 'DESC')
    ->get();


$lv="0";

     if(session('loggedUser'))
                    {
                        $love= new Love;
                    $lv=$love->where('cEmail',session("loggedUser")->email)->orderBy('pId', 'desc')->get();
                   // $lvCount = $love->where('cEmail',session("loggedUser")->email)->count('cEmail');

                    }
                    else{
                     return redirect()->route('gallery');  
                    }


    return view('allShares', ['products' => $p, 'likedProducts' =>$pLikes , 'userLikes' =>$lv, 
                                    
                                'loggedUser' => session('loggedUser')]);

    }

     public function addToShared(Request $request)
    {
      
        $image = $request->shareCanvas;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = str_random(10).'.'.'jpg';
        File::put('assets/img/' . $imageName, base64_decode($image));

      $p=['id'=>'132','path'=>$imageName,'price'=>$request->sharePrice,'tag'=>'','name'=>'','description'=>''];


       
      return view('singleShare')->with(['product' => $p, 
                        'loggedUser' => session('loggedUser')]);
    }



    public function shareComment(Request $request)
    {
        $product = new Product;

        $p = $product->where('id', $request->id)->first();

        $share = new Share;

        $s=$share->where('productId', $request->id)->get();

        return view('shareComment')->with(['product' => $p, 'comments'=>$s,
                                            'loggedUser' => session('loggedUser')]);

        //return $request->id;
    }




    public function commentToShare(Request $request)
    {

           $description=$request->description;
          $name=$request->name;


       
        $s = new Share;
        $s->productId = $request->id;
        $s->comment = $request->comment;
        $s->cId = session('loggedUser')->email;
        $s->save();

        return redirect()->route('share');
    }

     public function productForShare(Request $request)
    {
        $p = new Product;
         
     
        $p->price = $request->price;
        $p->path = $request->hidden_image;
        $p->name = $request->name;
        $p->tag = "";
        $p->description = $request->description;
        $p->addedBy = session('loggedUser')->email;
        $p->view = 0;
        $p->share = 1;
        $p->save();

        return redirect()->route('gallery');
    }


}
