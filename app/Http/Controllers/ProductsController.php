<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;

class ProductsController extends Controller
{
    public function CreateProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'skuNumber' => 'required',
            'category' => 'required',
            'supplier' => 'required',
            'numberAvailable' => 'required',
            'price' => 'required',
            ]);

        /*we create the record as shown below:*/

        $product = ProductModel::create([
            'name' => $request->name,
            'description' => $request->description,
            'skuNumber' => $request->skuNumber,
            'category' => $request->category,
            'supplier' => $request->supplier,
            'numberAvailable' => $request->numberAvailable,
            'price' => $request->price,
            ]);

        $product = ProductModel::find($product->id);
            if ($product) {
                return response(
                    [
                        'message' => 'success',
                        'product' => $product,
                        'status' => 200
                    ]
                );
            } else {
                return response(
                    [
                        'message' => 'error',
                        'product' => 'product does not exist!',
                        'status' => 404
                    ]
                );
            }
    }

    // READ ALL PRODUCTS

    public function getAllProducts(){
        $products = ProductModel::all();
        if($products){
        return response([
            'message'=> 'Success',
            'products' => $products
            ]);
        }else{
        return response([
            'message'=>'error',
            'products' => 'No products in database'
            ]);
        }
    }

    // READING A SINGLE PRODUCT
    function getProduct(Request $request){
        $request-> validate(['id'=> 'required']);
        $product = ProductModel::find($request->id);
        if($product){
          return response([
            'message'=> 'success',
            'products' => $product,
            'status'=> 200
          ]);
        }else{
          return response([
              'message'=> 'error',
              'products'=> 'Product does not exist',
              'status'=> 404
          ]);
        }
    }

    // UPDATE A PRODUCT
    function updateProduct(Request $request){
        $request -> validate([
          'id'=> 'required',
          'name'=> 'required',
          'description' => 'required',
          'skuNumber' => 'required',
          'category' => 'required',
          'supplier' => 'required',
          'numberAvailable' => 'required',
          'price' => 'required',
      ]);

      $product = ProductModel::find($request->id);

      if($product){
        $product->name = $request->name;
        $product->description = $request->description;
        $product->skuNumber = $request->skuNumber;
        $product->category = $request->category;
        $product->supplier = $request->supplier;
        $product->numberAvailable = $request->numberAvailable;
        $product->price = $request->price;
        $product->save();
        return response([
          'message'=>'success',
          'products'=> $product,
          'status'=> 200
          ]);
      } else{
        return response([
        'message'=> 'error',
        'products'=> 'Product doesn\'t exist',
        'status'=> 404
        ]);
        }
    }

    // DELETE A PRODUCT
    function deleteProduct(Request $request){
        $request->validate(['id'=> 'required']);
        $product = ProductModel::find($request->id);
        if($product){
          $product->delete();
            return response([
                'message'=>'success',
                'products'=> 'Product has been deleted successfully!',
                'status'=>200
           ]);
          }
        else{
          return response([
                'message'=> 'error',
                'products'=>'product does not exist!',
                'status'=>404
          ]);
          }
       }
}
