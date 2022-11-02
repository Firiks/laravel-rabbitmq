<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Jobs\ProductCreated;
use App\Jobs\ProductDeleted;
use App\Jobs\ProductUpdated;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    return Product::all();
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $product = Product::create($request->only('title', 'image'));

     ProductCreated::dispatch($product->toArray())->onQueue('main_queue');

    return response($product, Response::HTTP_CREATED);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return Product::find($id);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $product = Product::find($id);

    $product->update($request->only('title', 'image'));

    ProductUpdated::dispatch($product->toArray())->onQueue('main_queue');

    return response($product, Response::HTTP_ACCEPTED);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    Product::destroy($id);

    ProductDeleted::dispatch($id)->onQueue('main_queue');

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
