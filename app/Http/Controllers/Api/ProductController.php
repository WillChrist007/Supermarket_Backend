<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductController extends Controller
{
    
    public function index()
    {
        $products=Product::all();

        if(count($products)>0){
            return response([
                'message'=>'Retrieve All Success',
                'data'=>$products
            ],200);
        }

        return response([
            'message'=>'Empty',
            'data'=>null
        ],400);
    }


    public function store(Request $request)
    {
        $storeData=$request->all();

        $validate=Validator::make($storeData,[
            'nama_barang'=>'required|max:60|unique:products',
            'jenis'=>'required',
            'ketersediaan'=>'required',
            'harga'=>'required|numeric'
        ]);

        if($validate->fails())
            return response(['message'=>$validate->errors()],400);
        
        $product=Product::create($storeData);
        
        return response([
            'message'=>'add product success',
            'data'=>$product
        ],200);
    }

    public function show($id)
    {
        $product=Product::find($id);

        if(!is_null($product)){
            return response([
                'message'=>'retrieve product success',
                'data'=>$product
            ],200);
        }

        return response([
            'message'=>'Product not found',
            'data'=>null
        ],404);
    }

   
    public function update(Request $request, $id) 
    {
        $product = Product::find($id);
        if(is_null($product)){
            return response([
                'message' => 'Product Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_barang'=>'required|max:60|unique:products',
            'jenis'=>'required',
            'ketersediaan'=>'required',
            'harga'=>'required|numeric'
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);

        $product->nama_barang = $updateData['nama_barang'];
        $product->jenis = $updateData['jenis'];
        $product->ketersediaan = $updateData['ketersediaan'];
        $product->harga = $updateData['harga'];

        if($product->save()){
            return response([
                'message' => 'Update Product Success',
                'data' => $product
            ], 200);
        }

        return response([
            'message' => 'Update Product Failed',
            'data' => null
        ], 400);
    }
    
    public function destroy($id)
    {
        $product=Product::find($id);

        if(is_null($product)){
            return response([
                'message'=>'Product not found',
                'data'=>null
            ],404);
        }

        if($product->delete()){
            return response([
                'message'=>'delete Product success',
                'data'=>$product
            ],200);
        }

        return response([
            'message'=>'delete Product failed',
            'data'=>null
        ],400);
    }
}
