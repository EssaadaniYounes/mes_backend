<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\BasePost;
use App\Models\Classe;
use App\Models\Event;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use App\Services\CRUDHelper;
use App\Services\ExcelImport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
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

    public function getProfile()
    {
        $user = User::getProfileById(auth()->user()->id);
        return response()->json(['user' => $user,
            'auth' => auth()->user()->profile]);
    }


    public function getSuggestions(): JsonResponse
    {
        $users = User::with(['profile:user_id,full_name,profile_url','role:id,name'])
            ->where([
                ['id','!=',auth()->user()->id],
                ['univ_id',auth()->user()->univ_id]
            ])
            ->get();

        return response()->json($users);
    }

    public function createFromExcel(Request $request)
    {
        $path =  User::uploadUsers($request);

        $rows = (new ExcelImport())->importAndSave($path);
        $savedUsers = 0 ;

        $unrivaledLength =0;
        foreach ($rows as $row) {
            $email = $row[1];
            $password = $row[2];
            $role = $row[3];
            $class_id = null;
            if(isset($row[4])){
                $class_id = Classe::where('name',$row[4])->first()->id;
            }
            if($email && $row[1] && filter_var($email , FILTER_VALIDATE_EMAIL)){
                $role_id = $role == "teacher" ? 2 : 1;
                User::$full_name = $row[0];
                $user = [
                    'email' => $email,
                    'password' => bcrypt($password),
                    'role_id' => $role_id,
                    'univ_id' => auth()->user()->id,
                    'classe_id' => $class_id
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
            'message' => "{$savedUsers} users saved",
            'unrivaled' => $unrivaledLength
        ]);
    }
    public function createUsers(Request $request)
    {

        $i = 0;
        foreach ($request->all() as $user) {

            $role = $user['role'] == "student" ? 1 : 2;
            $class_id = null;
            if(isset($user['class'])){
                $class_id = Classe::where('name',$user['class'])->first()->id;
            }
            User::$full_name = $user['full_name'];
            $user = User::create([
                'email' => $user['email'],
                'role_id' => $role,
                'password' => bcrypt($user['password']),
                'univ_id' => auth()->user()->id,
                'classe_id' => $class_id
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
        $user = User::getProfileById($id);
        return response()->json([
            'user' => $user,
            'auth' => auth()->user()->profile]);
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
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $res = CRUDHelper::delete(User::class, $id);

        if($res){
            return response()->json(
                [
                    'success' => true,
                    'message' => 'User deleted successfully!'
                ]
            );
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete this user!!'
            ]);
        }
    }
}
