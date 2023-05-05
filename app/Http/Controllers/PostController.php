<?php

namespace App\Http\Controllers;

use App\Models\BasePost;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $basePost =[
            'content' => $request['content'],
            'user_id' => auth()->user()->id
        ];

        $basePost = BasePost::create($basePost);

        if($basePost){
            $course = Post::create([
                'base_post_id' => $basePost['id'],
                'files' => json_encode($request['attachments']),
                'post_type' => $request['post_type']
            ]);
            $course->load('basePost','basePost.user','basePost.user.profile');
            return response()->json([
                'success' => true,
                'data' => $course,
                'message' => 'Course created successfully'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => "Cannot create this post!"
        ]);
    }

    public function uploadAttachments(Request $request)
    {
        return Post::upload($request->file('files'));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
