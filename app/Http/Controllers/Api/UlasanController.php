<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Ulasan;

class UlasanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ulasans = Ulasan::all();

        if (count($ulasans) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $ulasans
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
            'isi' => 'required|max:100',
            'status' => 'required|numeric'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $ulasan = Ulasan::create($storeData);
        return response([
            'message' => 'Add ulasan Success',
            'data' => $ulasan
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
        $ulasan = Ulasan::find($id);

        if (!is_null($ulasan)) {
            return response([
                'message' => 'Retrieve ulasan Success',
                'data' => $ulasan
            ], 200);
        }

        return response([
            'message' => 'ulasan Not Found',
            'data' => null
        ], 404);
    }

    public function showAllByIdUser($id)
    {
        $ulasan = Ulasan::where('id_user', $id)->get();

        if (!is_null($ulasan)) {
            return response([
                'message' => 'Retrieve ulasan by id user Success',
                'data' => $ulasan
            ], 200);
        }

        return response([
            'message' => 'ulasan Not Found',
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
        $ulasan = Ulasan::find($id);
        if (is_null($ulasan)) {
            return response([
                'message' => 'ulasan Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'status' => 'required|numeric'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $ulasan->status = $updateData['status'];

        if ($ulasan->save()) {
            return response([
                'message' => 'Update ulasan Success',
                'data' => $ulasan
            ], 200);
        }

        return response([
            'message' => 'Update ulasan Failed',
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
        $ulasan = Ulasan::find($id);

        if (is_null($ulasan)) {
            return response([
                'message' => 'ulasan Not Found',
                'data' => null
            ], 404);
        }

        if ($ulasan->delete()) {
            return response([
                'message' => 'Delete ulasan Success',
                'data' => $ulasan
            ], 200);
        }

        return response([
            'message' => 'Delete ulasan Failed',
            'data' => null
        ], 400);
    }
}
