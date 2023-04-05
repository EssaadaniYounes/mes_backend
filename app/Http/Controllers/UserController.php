<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use App\Services\ExcelImport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('role','profile')
                        ->where('univ_id',auth()->user()->id)
                            ->orderByDesc('created_at')
                                ->get();
        return response()->json($users,200);
    }
    public function getAuthenticatedUser(): JsonResponse{

        $user = User::getUserInfo(auth()->user()->id);
        return response()->json($user);

    }

    public function createFromExcel(Request $request)
    {
        $path = User::uploadUsers($request);
        $rows = (new ExcelImport())->importAndSave(public_path($path));
        $savedUsers = 0 ;

        $unrivaledLength =0;
        foreach ($rows as $row) {
            $email = $row[0];
            $password = $row[1];
            $role = $row[2];
            if($email && $row[1] && filter_var($email , FILTER_VALIDATE_EMAIL)){
                $role_id = $role == "teacher" ? 2 : 1;
                $user = [
                    'email' => $email,
                    'password' => bcrypt($password),
                    'role_id' => $role_id,
                    'univ_id' => auth()->user()->id
                ];
                $stored = User::create($user);
                if($stored){
                    $savedUsers++;
                }
           } else{
                $unrivaledLength++;
            }
        }
        return response()->json([
            'saved' => $savedUsers,
            'unrivaled' => $unrivaledLength
        ]);
    }
    public function createUsers(Request $request)
    {

        $i = 0;
        foreach ($request->all() as $user) {

            $role = $user['role'] == "student" ? 1 : 2;
            $user = User::create([
                'email' => $user['email'],
                'role_id' => $role,
                'password' => bcrypt($user['password']),
                'univ_id' => auth()->user()->id
            ]);
            $i++;
        }
        return response()->json([
            "message" => "{$i} users saved"
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
