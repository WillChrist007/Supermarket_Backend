<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

use function PHPUnit\Framework\returnSelf;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        if (count($products) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $products
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_barang' => 'required|max:100',
            'jenis' => 'required',
            'ketersediaan' => 'required|numeric',
            'harga' => 'required|numeric',
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $product = Product::create($storeData);
        return response()->json([
            'message' => 'Add product Success',
            'data' => $product
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!is_null($product)) {
            return response([
                'message' => 'Retrieve product Success',
                'data' => $product
            ], 200);
        }

        return response([
            'message' => 'product Not Found',
            'data' => null
        ], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        if (is_null($product)) {
            return response([
                'message' => 'product Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_barang' => 'required|max:100',
            'jenis' => 'required',
            'ketersediaan' => 'required|numeric',
            'harga' => 'required|numeric',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $product->nama_barang = $updateData['nama_barang'];
        $product->jenis = $updateData['jenis'];
        $product->ketersediaan = $updateData['ketersediaan'];
        $product->harga = $updateData['harga'];

        if ($product->save()) {
            return response([
                'message' => 'Update product Success',
                'data' => $product
            ], 200);
        }

        return response([
            'message' => 'Update product Failed',
            'data' => null
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return response([
                'message' => 'product Not Found',
                'data' => null
            ], 404);
        }

        if ($product->delete()) {
            return response([
                'message' => 'Delete product Success',
                'data' => $product
            ], 200);
        }

        return response([
            'message' => 'Delete product Failed',
            'data' => null
        ], 400);
    }
}
