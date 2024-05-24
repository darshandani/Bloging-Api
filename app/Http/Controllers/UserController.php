<?php

namespace App\Http\Controllers;

use App\Models\Registers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class UserController extends ApiController
{
   
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Registers::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->respondWithSuccess("register sucess");
    }

    /**
     * Display the specified resource.
     */
    public function login(Request $request)
    {
        $inputdata = $request->all();

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,

        ];

        if (auth()->attempt($credentials)) {
            $data = auth()->user();

            $data->token = auth()->user()->createToken('darshan')->accessToken;


            $data->makeHidden('updated_at');
            $data->makeHidden('created_at');


            return $this->respondWithData($data, NULL);
        } else {
            return $this->respondWithError(['Error! Invalid Username or Password']);
        }
    }
    public function logout(Request $res)
    {

        $token = auth()?->user()?->token();
        $token?->revoke();
        return $this->respondWithSuccess('Logout successfully.');
    }
}
