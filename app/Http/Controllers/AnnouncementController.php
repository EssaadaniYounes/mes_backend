<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\BasePost;
use App\Models\ClasseAnnouncement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUserId = auth()->user();
        $announcements = Announcement::with(['classeAnnouncements', 'basePost.user'])
            ->whereHas('classeAnnouncements', function ($query) use ($currentUserId) {
                $query->where('classe_id', $currentUserId->classe_id);
            })
            ->orWhereHas('basePost', function ($query) use ($currentUserId) {
                $query->where('user_id', $currentUserId->id);
            })
            ->get();

        return response()->json([
            'announcements' => $announcements
        ]);

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
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;

        $basePost = BasePost::create($data);
        $announcement = Announcement::create([
            'base_post_id' => $basePost->id
        ]);
        foreach ($data['classes'] as $class) {
            ClasseAnnouncement::create([
                'announcement_id' => $basePost->id,
                'classe_id' => $class
            ]);
        }
        $announcement->load('basePost','basePost.user','basePost.user.profile');
        return response()->json(
            [
                $announcement
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Announcement $announcement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
    {
        //
    }
}
