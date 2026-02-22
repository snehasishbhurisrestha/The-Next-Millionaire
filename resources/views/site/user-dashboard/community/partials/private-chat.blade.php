<div class="d-flex flex-column h-100" id="privateChatBox" data-chat-id="{{ $chat->id }}">

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
        <div class="message-row {{ $msg->user_id == auth()->id() ? 'me' : '' }}" id="msg-{{ $msg->id }}">
        
            @if($msg->user_id != auth()->id())
                <div class="avatar">
                    <img src="{{ $msg->user->getFirstMediaUrl('user-image') ?: asset('assets/user-admin-assets/img/default-user.png') }}">
                </div>
            @endif
        
            <div class="message-bubble"
                 data-id="{{ $msg->id }}"
                 data-user="{{ $msg->user->name }}"
                 data-text="{{ Str::limit(strip_tags($msg->message), 50) }}">
        
                {{-- IF MESSAGE IS DELETED --}}
                @if($msg->deleted_at)
        
                    <i class="deleted-msg">This message was deleted</i>
                    <small class="msg-time">
                        {{ $msg->created_at->format('h:i a') }}
                    </small>
        
                @else
        
                    {{-- RIGHT CLICK / LONG PRESS --}}
                    <div class="msg-menu"
                         oncontextmenu="openMsgMenu(event, {{ $msg->id }}, {{ $msg->user_id == auth()->id() ? 'true' : 'false' }}); return false;">
        
                        {{-- REPLY BOX --}}
                        @if($msg->replyTo)
                            <div class="reply-box" onclick="scrollToMessage({{ $msg->replyTo->id }})">
                                <small>{{ $msg->replyTo->user->name }}</small>
                                <div>{{ Str::limit($msg->replyTo->message, 60) }}</div>
                            </div>
                        @endif
        
                        {!! $msg->message !!}
        
                        <small class="msg-time">
                            {{ $msg->created_at->format('h:i a') }}
                        </small>
        
                    </div>
        
                @endif
        
            </div>
        </div>
        @endforeach

    </div>

    <!-- REPLY PREVIEW BAR -->
    <div id="replyPreview" class="reply-preview" style="display:none;">
        <div>
            <small id="replyUser"></small>
            <div id="replyText"></div>
        </div>
        <button class="btn" onclick="cancelReply()">✕</button>
    </div>

    <!-- INPUT -->
    <div class="chat-input">
        <textarea id="privateMessageInput" rows="1" placeholder="Type your message…"></textarea>
        <button onclick="sendPrivateMessage({{ $chat->id }})">Send</button>
    </div>
    
    <div id="msgContextMenu" class="msg-context-menu">
        <button onclick="doReply()">Reply</button>
        <button id="deleteBtn" onclick="doDelete()">Delete</button>
    </div>


</div>
