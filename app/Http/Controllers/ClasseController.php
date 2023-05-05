<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Services\CRUDHelper;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $classes = Classe::select('id','name')
                    ->withCount('users')
                    ->where('univ_id', auth()->user()->id)
                    ->orderByDesc('created_at')
                    ->get();
        return  response()->json($classes,200);
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
    public function store(Request $request): JsonResponse
    {

        try {
            $class = [
                'name' => $request->all()['name'],
                'univ_id' => auth()->user()->id
            ];
            $class = Classe::create($class);
            if(!$class){
                response()->json([
                    'message'=>'Cannot create this class',
                    'success'=>false,
                    'data'=>null],400);
            }
            return response()->json([
                'message' => 'Created Successfully',
                'success' => true,
                'data' => $class
            ],200);
        }catch (QueryException $ex){
            return  response()->json([
                'message'=>'Some fields are undefined!!',
                'success'=>false,
                'data'=>null],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function show(Classe $classe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function edit(Classe $classe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classe $classe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classe  $classe
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {

        $res = CRUDHelper::delete(Classe::class, $id);

        if($res){
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Class deleted successfully!'
                ]
            );
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete this class!!'
            ]);
        }
    }
}
