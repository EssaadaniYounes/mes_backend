<?php

namespace App\Http\Controllers;

use App\Models\BasePost;
use App\Models\Event;
use App\Services\CRUDHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $events = Event::whereHas('basePost',function($q){
                $q->where('user_id',auth()->user()->id);
            })
            ->with('basePost')
            ->get();
        return response()->json($events);
    }

    public function getByType($type): JsonResponse
    {
        $events = Event::whereHas('basePost',function($q){
            $q->where('user_id',auth()->user()->univ_id);
        })
            ->with('basePost')
            ->where('event_type',$type)
            ->get();
        return response()->json($events);
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
    public function store(Request $request):JsonResponse
    {
        $basePost =[
            'content' => $request['content'],
            'user_id' => auth()->user()->id
        ];

        $basePost = BasePost::create($basePost);

        if($basePost){
            $event = Event::create([
                'base_post_id' => $basePost['id'],
                'title' => $request['title'],
                'thumbnail' => $request['thumbnail'],
                'files' => $request['attachments'],
                'event_type' => $request['event_type'],
                'event_date' => $request['event_date'],

            ]);
            $event->load('basePost','basePost.user','basePost.user.profile');
            return response()->json([
                'success' => true,
                'data' => $event,
                'message' => 'Event created successfully'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => "Cannot create this post!"
        ]);
    }
    public function uploadAttachments(Request $request)
    {
        $isMultiple = $request->ismultiple;

        $stored = $isMultiple ?
            Event::upload($request->file('files'))
                : Event::uploadSingle($request);
        return response()->json($stored);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {

        $res = CRUDHelper::delete(BasePost::class, $id);

        if($res){
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Event deleted successfully!'
                ]
            );
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete this event!!'
            ]);
        }
    }
}
