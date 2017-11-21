<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::with(['user', 'comments', 'productPhotos', 'category'])->get();
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'min_quantity' => 'required',
            'price' => 'required',
            'category_id' => 'required',
        ];

        $photos = count($request->file('images'));

        foreach (range(0, $photos) as $index) {
            $rules['images.*.' . $index] = 'image|mimes:jpeg,jpg,bmp,png|max:2500';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->all()]);
        }

        $product = new Product(array_merge($request->all(), ['user_id' => $request->user('api')->id]));

        $product->save();

        $product_photo = null;

        if ($request->hasFile('images')) {

            $images = $request->file('images');

            if (count($images) == 1) {
                $filename = $images->store('photos');
                ProductPhoto::create([
                    'product_id' => $product->id,
                    'filename' => $filename
                ]);
            } elseif (count($images) > 1) {

                foreach ($request->images as $image) {
                    $filename = $image->store('photos');
                    ProductPhoto::create([
                        'product_id' => $product->id,
                        'filename' => $filename
                    ]);
                }
            }

            $product = Product::where('id', $product->id)->with(['productPhotos', 'user', 'comments'])->first();

            return response()->json($product);

            /*   return $product_photo ? response()->json(['error' => false, 'message' => 'Votre produit a bien ete publie', 'product' => $product]) :
                   response()->json(['error' => true, 'message' => "Votre produit n'a pas bien ete publie"]);*/
        } else {

            $product = Product::where('id', $product->id)->with(['productPhotos', 'user', 'comments'])->first();
            return response()->json($product);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        //
        $products = Product::where('user_id', $user_id)->with(['user', 'comments', 'productPhotos'])->get();
        return response()->json($products);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
