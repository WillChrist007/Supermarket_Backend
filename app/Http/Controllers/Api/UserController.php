<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users=User::all();

        if(count($users)>0){
            return response([
                'message'=>'Retrieve All Success',
                'data'=>$users
            ],200);
        }

        return response([
            'message'=>'Empty',
            'data'=>null
        ],400);
    }    

    public function show($id)
    {
        $user=User::find($id);

        if(!is_null($user)){
            return response([
                'message'=>'retrieve user success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'User not found',
            'data'=>null
        ],404);
    }

   
    public function update(Request $request, $id) 
    {
        $user = User::find($id);
        if(is_null($user)){
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'email'=>'required|email:rfc,dns|unique:users',
            'password'=>['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()],
            'nama'=>'required|max:60',
            'telepon' => 'required|numeric|digits_between:11,13|starts_with:08',
            'alamat' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);

        $user->email = $updateData['email'];
        $user->password = $updateData['password'];
        $user->nama = $updateData['nama'];
        $user->telepon = $updateData['telepon'];
        $user->alamat = $updateData['alamat'];

        if($user->save()){
            return response([
                'message' => 'Update User Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Update User Failed',
            'data' => null
        ], 400);
    }
    
    public function destroy($id)
    {
        $user=User::find($id);

        if(is_null($user)){
            return response([
                'message'=>'User not found',
                'data'=>null
            ],404);
        }

        if($user->delete()){
            return response([
                'message'=>'delete User success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'delete User failed',
            'data'=>null
        ],400);
    }
}