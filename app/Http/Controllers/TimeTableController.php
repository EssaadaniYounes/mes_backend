<?php

namespace App\Http\Controllers;

use App\Models\TimeTable;
use App\Services\CRUDHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TimeTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $timeTables = TimeTable::whereHas('classe',function($q){
                $q->where('univ_id', auth()->user()->id);
            })->with('classe:name,id')
            ->get();
        return response()->json($timeTables);
    }

    public function getCurrentUserResult()
    {
        $data = TimeTable::whereHas('classe',function($q){
            $q->where('id',auth()->user()->classe->id);
        })
            ->with(['classe:id,name'])
            ->orderByDesc('created_at')
            ->first();

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): JsonResponse
    {
        $timeTable = TimeTable::create($request->all());
        return response()->json($timeTable);
    }

    public function uploadFile(Request $request): JsonResponse
    {
        $filePath = TimeTable::uploadTimeTable($request);
        return response()->json([
            'url' => $filePath
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param TimeTable $timeTable
     * @return Response
     */
    public function show(TimeTable $timeTable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TimeTable $timeTable
     * @return Response
     */
    public function edit(TimeTable $timeTable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param TimeTable $timeTable
     * @return Response
     */
    public function update(Request $request, TimeTable $timeTable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TimeTable $timeTable
     * @return Response
     */
    public function destroy($id)
    {

        $res = CRUDHelper::delete(TimeTable::class, $id);

        if($res){
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Time table deleted successfully!'
                ]
            );
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete this time table!!'
            ]);
        }
    }
}
