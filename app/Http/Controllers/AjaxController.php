<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
//use App\Share;
use App\Love;


class AjaxController extends Controller {


//$this->middleware(function ($request, $next) { Talk::setAuthUserId(Auth::user()->id); return $next($request); });

   public function index(Request $request) {

   	$id=$request->pId;
   		$dis=$request->dis;
      



     if($dis=='0')
      {


 
         $x = Love::where('cEmail', session('loggedUser')->email)
                ->where('pId', $id)
                ->Delete();
      

      // $x->Delete();

      	 /*DB::table('loves')->where('pId',$id )
                               ->where('cEmail', session('loggedUser')->email)
      	                        
                                 ->delete();
       	 $l=new Love;
         $x = $l->where('cEmail', session('loggedUser')->email)
                ->where('pId', $id)
                ->get();
      

       $x->Delete();*/

              //  $account= Account::find($id);

        //dd($account);
       // return view('account.delete')->with('account', $account);

      }
      else
      {
      	$l=new Love;
      	$l->pId=$id;
      	$l->cEmail=session('loggedUser')->email;
      	$l->save();

      }
     // return response()->json(array('msg'=> $msg), 200);
        // return view('messagePage', ['msg' => $msg]);
      //return view('create');

         //  $s = new Share;
        //$s->productId = "1";
        //$s->comment = "4545";
        //$s->cId = "jjkjk";
        //$s->save();


      return response()->json(['pId' => $id]);
   }
}