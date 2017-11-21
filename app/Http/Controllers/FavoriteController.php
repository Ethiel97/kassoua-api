<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user('api');
        $favorites = Favorite::where('user_id', $user->id)->get();

        $products = null;
        foreach ($favorites as $key => $favorite) {
            $product = Product::where('id', $favorite->product_id)->with('user', 'comments', 'productPhotos')->first();
            $products[$key] = $product;
        }
        return response()->json($products);
    }

    public function store(Request $request)
    {
//        $user = Auth::guard('api')->user();
        $user = $request->user('api');
        if ($product = Product::find($request->product_id)) {
//            $favorite = new Favorite($request->except('user_id'));
            $favorite = new Favorite($request->all());
            $user->favorites()->save($favorite);

            return response()->json("Success");
        } else
            return response()->json("Failure");
    }

    public function show($user_id)
    {
        $favorites = Favorite::where('user_id', $user_id)->get();

        $products = null;
        foreach ($favorites as $key => $favorite) {
            $product = Product::where('id', $favorite->product_id)->with('user', 'comments', 'productPhotos')->first();
            $products[$key] = $product;
        }
        return response()->json($products);
    }


    public function destroy($id)
    {
        if ($favorite = Favorite::where('product_id', $id)->where('user_id', Auth::user('api')->id)->first()) {
            $favorite->delete();
            return response()->json("Success");
        } else
            return response()->json("Failure");
    }
}
