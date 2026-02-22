<?php

namespace App\Http\Controllers\Site\UserDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\CommunityMessage;
use App\Models\PrivateChat;
use App\Models\PrivateMessage;
use App\Models\User;

use App\Events\CommunityMessageSent;
use App\Events\PrivateMessageSent;
use App\Events\MessageDeleted;

class CommunityController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MAIN VIEW
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $pinned = CommunityMessage::where('is_pinned',1)->latest()->first();

        $messages = CommunityMessage::with('user')
            ->latest()
            // ->take(50)
            ->get()
            ->reverse();

        // 🔥 ACCEPTED CHATS (CHAT LIST)
        $chats = PrivateChat::with([
                'sender',
                'receiver',
                'messages' => fn($q) => $q->latest()->limit(1)
            ])
            // ->where('status', 'accepted')
            ->where(function ($q) {
                $q->where('sender_id', auth()->id())
                ->orWhere('receiver_id', auth()->id());
            })
            ->orderBy(
                PrivateMessage::select('created_at')
                    ->whereColumn('private_messages.chat_id', 'private_chats.id')
                    ->latest()
                    ->limit(1),
                'desc'
            )
            ->get();

        // 🔥 PENDING REQUESTS
        $requests = PrivateChat::with('sender')
            ->where('receiver_id', auth()->id())
            ->where('status', 'pending')
            ->get();

        return view(
            'site.user-dashboard.community.index',
            compact('pinned','messages','chats','requests')
        );
    }

    public function get_members(){
        $members = User::role('User')
                    ->where('id', "!=", auth()->id())
                    ->where('status',1)
                    ->get()
                    ->map(function ($user) {
                        $avatar = $user->getFirstMediaUrl('user-image');

                        if (!$avatar || trim($avatar) === '') {
                            $avatar = asset('assets/user-admin-assets/img/default-user.png');
                        }

                        return [
                            'id' => $user->id,
                            'name' => $user->name,
                            'avatar' => $avatar
                        ];
                    });

        return response()->json([
            "status" => true,
            "members" => $members
        ]);
    }
    
    /*
    |--------------------------------------------------------------------------
    | SEND COMMUNITY MESSAGE
    |--------------------------------------------------------------------------
    */
    public function sendCommunity(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $todayCount = CommunityMessage::whereDate('created_at', today())
            ->where('user_id', auth()->id())
            ->count();

        // if(!auth()->user()->hasRole('admin') && $todayCount >= 2){
        //     return response()->json(['error'=>'Daily limit reached'],403);
        // }

        $msg = CommunityMessage::create([
            'user_id' => auth()->id(),
            'message' => strip_tags($request->message,'<a>'),
            'is_pinned' => auth()->user()->hasRole('admin') && $request->pin ? 1 : 0,
            'reply_to_id' => $request->reply_to_id
        ]);
        
        $msg->load('user');

        broadcast(new CommunityMessageSent($msg))->toOthers();
        // broadcast(new \App\Events\CommunityMessageSent($msg));

        return response()->json($msg);
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT MESSAGE (5 MIN)
    |--------------------------------------------------------------------------
    */
    public function editCommunity(Request $request,$id)
    {
        $msg = CommunityMessage::findOrFail($id);

        if($msg->user_id !== auth()->id() || !$msg->canEdit()){
            abort(403);
        }

        $msg->update(['message'=>$request->message]);

        return response()->json(['success'=>true]);
    }

    /*
    |--------------------------------------------------------------------------
    | PRIVATE CHAT REQUEST
    |--------------------------------------------------------------------------
    */
    public function requestChat($userId)
    {
        if(auth()->user()->isChatBlockedWith($userId)){
            abort(403);
        }

        $chat = PrivateChat::firstOrCreate([
            'sender_id'=>auth()->id(),
            'receiver_id'=>$userId
        ]);

        return response()->json(['status'=>$chat->status]);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCEPT / BLOCK CHAT
    |--------------------------------------------------------------------------
    */
    public function updateChatStatus(Request $request,$chatId)
    {
        $chat = PrivateChat::findOrFail($chatId);

        if($chat->receiver_id !== auth()->id()){
            abort(403);
        }

        $chat->update(['status'=>$request->status]);

        return response()->json(['success'=>true]);
    }

    /*
    |--------------------------------------------------------------------------
    | SEND PRIVATE MESSAGE
    |--------------------------------------------------------------------------
    */

    public function sendPrivate(Request $request, $chatId)
    {
        $chat = PrivateChat::findOrFail($chatId);

        // if ($chat->status !== 'accepted') abort(403);

        $msg = PrivateMessage::create([
            'chat_id' => $chat->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
            'reply_to_id' => $request->reply_to_id
        ]);

        broadcast(new PrivateMessageSent($msg))->toOthers();

        return response()->json($msg);
    }
    
    public function privateChat($id)
    {
        $user = User::findOrFail($id);
        $authId = auth()->id();

        $chat = PrivateChat::firstOrCreatePrivate($authId, $id); // I can define this

        // $messages = $chat->messages()->with('user')->get();
        $messages = $chat->messages()
                        ->withTrashed()
                        ->with('user')
                        ->get();


        return view('site.user-dashboard.community.partials.private-chat', compact('chat', 'user', 'messages'));
    }
    
    public function deleteMessage($id)
    {
        $msg = PrivateMessage::findOrFail($id);
    
        if ($msg->user_id != auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $msg->delete();
    
        broadcast(new MessageDeleted($msg->id, $msg->chat_id, $msg->created_at->format('h:i a')))->toOthers();
    
        return response()->json(['success' => true]);
    }



}