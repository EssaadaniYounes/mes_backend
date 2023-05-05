<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index()
    {
    }

    /**
     * Registration
     */
    public function register(Request $request)
    {

        $user = User::create([
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => bcrypt($request->password),
        ]);
        $profile =[
            'full_name' => $request->full_name ?? 'unknown',
            'user_id' => $user->id
        ];
        Profile::create($profile);
        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json(['token' => $token,'profile' => $profile, 'success' => true], 200);
    }

    /**
     * Login
     */
    public function login(Request $request)
    {



        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (auth()->attempt($data)) {
            $user = auth()->user();
            $user->role = User::find($user->id)->role->name;
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;

            return response()->json(['success' => true, 'token' => $token,'user'=>$user], 200);
        } else {
            return response()->json(['success' => false, 'error' => 'Email or password incorrect try again!']);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }
}
