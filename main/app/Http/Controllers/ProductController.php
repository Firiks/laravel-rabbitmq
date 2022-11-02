<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Jobs\ProductLiked;
use App\Models\ProductUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
  public function index()
  {
    return Product::all();
  }

  public function like($id, Request $request)
  {
    $response = Http::get('http://host.docker.internal:8000/api/user'); // internal request to get user

    $user = $response->json();

    try {
      $productUser = ProductUser::create([
        'user_id' => $user['id'],
        'product_id' => $id
      ]);

      ProductLiked::dispatch($productUser->toArray())->onQueue('admin_queue');

      return response([
        'message' => 'success'
      ]);
    } catch (\Exception $exception) {
      return response([
          'error' => 'Product already liked.'
      ], Response::HTTP_BAD_REQUEST);
    }
  }
}
