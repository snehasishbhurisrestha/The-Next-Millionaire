<div class="d-flex flex-column h-100">

    <!-- HEADER -->
    <div style="display:flex;align-items:center;gap:10px;padding:10px;border-bottom:1px solid #1e293b;">
        <button onclick="backToCommunity()" style="background:none;border:none;color:#facc15;font-size:18px;">
            ←
        </button>

        <div class="avatar">
            <img src="{{ $user->getFirstMediaUrl('user-image') ?: asset('assets/user-admin-assets/img/default-user.png') }}">
        </div>

        <div style="font-weight:600">{{ $user->name }}</div>
    </div>

    <!-- MESSAGES -->
    <div id="privateChatMessages" class="chat-area">
        @foreach($messages as $msg)
            <div class="message-row {{ $msg->user_id == auth()->id() ? 'me' : '' }}">
                
                @if($msg->user_id != auth()->id())
                    <div class="avatar">
                        <img src="{{ $msg->user->getFirstMediaUrl('user-image') ?: asset('assets/user-admin-assets/img/default-user.png') }}">
                    </div>
                @endif

                <div class="message-bubble">
                    {!! $msg->message !!}
                </div>
            </div>
        @endforeach
    </div>

    <!-- INPUT -->
    <div class="chat-input">
        <textarea id="privateMessageInput" rows="1" placeholder="Type your message…"></textarea>
        <button onclick="sendPrivateMessage({{ $chat->id }})">Send</button>
    </div>

</div>
