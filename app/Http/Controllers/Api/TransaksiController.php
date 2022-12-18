<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksis = Transaksi::all();

        if (count($transaksis) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $transaksis
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
            'id_user' => 'required|max:100',
            'id_product' => 'required|max:100',
            'jumlah' => 'required|numeric',
            'status' => 'required|numeric'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $transaksi = Transaksi::create($storeData);
        return response([
            'message' => 'Add transaksi Success',
            'data' => $transaksi
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
        $transaksi = Transaksi::find($id);

        if (!is_null($transaksi)) {
            return response([
                'message' => 'Retrieve transaksi Success',
                'data' => $transaksi
            ], 200);
        }

        return response([
            'message' => 'transaksi Not Found',
            'data' => null
        ], 404);
    }

    public function showAllByIdUser($id)
    {
        $transaksi = Transaksi::where('id_user', $id)->get();

        if (!is_null($transaksi)) {
            return response([
                'message' => 'Retrieve transaksi by id user Success',
                'data' => $transaksi
            ], 200);
        }

        return response([
            'message' => 'transaksi Not Found',
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
        $transaksi = Transaksi::find($id);
        if (is_null($transaksi)) {
            return response([
                'message' => 'transaksi Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'jumlah' => 'required|numeric',
            'status' => 'required|numeric'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $transaksi->jumlah = $updateData['jumlah'];
        $transaksi->status = $updateData['status'];

        if ($transaksi->save()) {
            return response([
                'message' => 'Update transaksi Success',
                'data' => $transaksi
            ], 200);
        }

        return response([
            'message' => 'Update transaksi Failed',
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
        $transaksi = Transaksi::find($id);

        if (is_null($transaksi)) {
            return response([
                'message' => 'transaksi Not Found',
                'data' => null
            ], 404);
        }

        if ($transaksi->delete()) {
            return response([
                'message' => 'Delete transaksi Success',
                'data' => $transaksi
            ], 200);
        }

        return response([
            'message' => 'Delete transaksi Failed',
            'data' => null
        ], 400);
    }
}
