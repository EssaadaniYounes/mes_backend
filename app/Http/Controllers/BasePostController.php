<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\BasePost;
use App\Models\Event;
use App\Models\Post;
use Faker\Provider\Base;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BasePostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $relations = ['basePost','basePost.user','basePost.user.profile'];
        $announcement = Announcement::with($relations)
                        ->get()
                        ->toArray();
        $posts = Post::with($relations)
                        ->get()
                        ->toArray();
        $events = Event::with($relations)
                        ->get()
                        ->toArray();

        $merged = array_merge($announcement, $posts,$events);
        usort($merged,function($a, $b) {
                return strcmp( $b['base_post']['created_at'],$a['base_post']['created_at']);
        });

        return response()->json(\GuzzleHttp\json_decode(json_encode($merged)));
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BasePost  $basePost
     * @return \Illuminate\Http\Response
     */
    public function show(BasePost $basePost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BasePost  $basePost
     * @return \Illuminate\Http\Response
     */
    public function edit(BasePost $basePost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BasePost  $basePost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BasePost $basePost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BasePost  $basePost
     * @return \Illuminate\Http\Response
     */
    public function destroy(BasePost $basePost)
    {
        //
    }
}
