<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\TimeTable;
use App\Services\CRUDHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Result::whereHas('classe',function($q){
            $q->where('univ_id', auth()->user()->id);
        })->with('classe:name,id')
            ->get();
        return response()->json($results);
    }

    public function getCurrentUserResult()
    {
        $result = Result::whereHas('classe',function($q){
            $q->where('id',auth()->user()->classe->id);
        })
            ->with(['classe:id,name'])
            ->orderByDesc('created_at')
            ->first();

        return response()->json($result);
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
        $result = Result::create($request->all());
        return response()->json($result);
    }

    public function uploadFile(Request $request): JsonResponse
    {
        $filePath = Result::uploadTimeTable($request);
        return response()->json([
            'url' => $filePath
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function show(Result $result)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function edit(Result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Result  $result
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {

        $res = CRUDHelper::delete(Result::class, $id);

        if($res){
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Result deleted successfully!'
                ]
            );
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete this result!!'
            ]);
        }
    }
}
