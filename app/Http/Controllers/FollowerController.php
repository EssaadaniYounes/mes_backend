<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }


    public function follow(Request $request)
    {
        $follower_id = auth()->user()->id;
        $following_id = $request['following_id'];

        $follower = Follower::create([
            'follower_id' => $follower_id,
            'following_id' => $following_id,
        ]);

        return response()->json($follower, 201);
    }

    public function unfollow(Request $request): JsonResponse
    {
        $follower_id = auth()->user()->id;
        $following_id = $request['following_id'];

        $follower = Follower::where('follower_id', $follower_id)
            ->where('following_id', $following_id)
            ->first();

        if ($follower) {
            $follower->delete();
        }

        return response()->json(null, 204);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Follower  $follower
     * @return \Illuminate\Http\Response
     */
    public function show(Follower $follower)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Follower  $follower
     * @return \Illuminate\Http\Response
     */
    public function edit(Follower $follower)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Follower  $follower
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Follower $follower)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Follower  $follower
     * @return \Illuminate\Http\Response
     */
    public function destroy(Follower $follower)
    {
        //
    }
}
