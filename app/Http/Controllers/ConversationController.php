<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $conversations = auth()->user()->conversations;
        return response()->json([
            'conversations' => $conversations,
            'user' => auth()->user(),
        ]);
    }

    public function getSuggestions()
    {
        $users = User::with(['profile:user_id,full_name,profile_url','role:id,name'])
            ->where([
                ['id','!=',auth()->user()->id],
                ['univ_id',auth()->user()->univ_id]
            ])
            ->get();

        return response()->json($users);
    }

    public function getMessages($id){
        $conversation = Conversation::find($id);
        $otherUserId = ($conversation->started_by === auth()->id())
            ? $conversation->second_user
            : $conversation->started_by;

        $messages = $conversation->messages()->with('sentBy')
            ->orderBy('created_at', 'asc')
            ->get();
        $otherUser = User::find($otherUserId)->load('profile');
        return response()->json([
            'user' => auth()->user()->load('profile'),
            'other_user' => $otherUser,
            'messages' => $messages
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
    public function store(Request $request)
    {
        $conversation = Conversation::where([
            ['started_by','=',$request['user_id']],
            ['second_user', '=', auth()->user()->id],
        ])
            ->orWhere([
                ['started_by','=',auth()->user()->id],
                ['second_user', '=',$request['user_id'] ],
            ])
            ->first();
        if($conversation){
            return response()->json($conversation);
        }
        $conversation = Conversation::create([
            'started_by' => auth()->user()->id,
            'second_user' => $request['user_id']
        ]);
        return response()->json($conversation);
    }


    public function markRead($id)
    {
        $conversation = Conversation::find($id);
        $conversation->markRead();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function edit(Conversation $conversation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conversation $conversation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversation $conversation)
    {
        //
    }
}
