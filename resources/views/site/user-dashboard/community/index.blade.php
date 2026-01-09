@extends('layouts.user-dashboard')
@section('title','Community')

@section('style')
<style>
    /* LAYOUT */
    .community-container{
        height: calc(100vh - 163px);
        display:flex;
        flex-direction:column;
        /* background:#0b1120; */
        color:#fff;
    }

    /* TABS */
    .community-tabs{
        display:flex;
        border-bottom:1px solid #1e293b;
    }
    .community-tab{
        flex:1;
        text-align:center;
        padding:12px;
        cursor:pointer;
        font-weight:600;
        color:#94a3b8;
    }
    .community-tab.active{
        color:#facc15;
        border-bottom:2px solid #facc15;
    }

    /* CONTENT */
    .community-content{
        flex:1;
        overflow:hidden;
        display:none;
    }
    .community-content.active{
        display:flex;
        flex-direction:column;
    }

    /* CHAT */
    .chat-area{
        flex:1;
        overflow-y:auto;
        padding:15px;
    }
    .message-row{
        display:flex;
        margin-bottom:14px;
    }
    .message-row.me{
        justify-content:flex-end;
    }
    .message-bubble{
        max-width:75%;
        padding:10px 14px;
        border-radius:14px;
        background:#020617;
    }
    .message-row.me .message-bubble{
        background:#1e293b;
    }
    .message-user{
        font-size:12px;
        font-weight:600;
        color:#facc15;
        margin-bottom:4px;
    }

    /* AVATAR */
    .avatar{
        width:36px;
        height:36px;
        border-radius:50%;
        background:#334155;
        margin-right:10px;
        overflow: hidden;
    }
    .message-row.me .avatar{
        display:none;
    }

    .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* INPUT */
    .chat-input{
        border-top:1px solid #1e293b;
        padding:10px;
        display:flex;
        gap:10px;
    }
    .chat-input textarea{
        flex:1;
        resize:none;
        background:#020617;
        border:none;
        color:#fff;
        padding:10px;
        border-radius:10px;
    }
    .chat-input button{
        background:#facc15;
        border:none;
        padding:0 18px;
        border-radius:10px;
        font-weight:600;
    }

    /* MEMBERS */
    .member-item{
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding:12px;
        border-bottom:1px solid #1e293b;
    }
    .member-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        border-bottom: 1px solid #eee;
    }
</style>
@endsection


@section('content')

<div class="community-container">

    <!-- TABS -->
    <div class="community-tabs">
        <div class="community-tab active" onclick="switchTab('community')">Community</div>
        <div class="community-tab" onclick="switchTab('requests')">Messages</div>
        <div class="community-tab" onclick="switchTab('members')">Members</div>
    </div>

    <!-- COMMUNITY CHAT -->
    <div id="tab-community" class="community-content active">

        @if($pinned)
            <div class="p-2 bg-warning text-dark text-center">
                📌 {!! $pinned->message !!}
            </div>
        @endif

        <div id="chatMessages" class="chat-area">
            @foreach($messages as $msg)
                <div class="message-row {{ $msg->user_id == auth()->id() ? 'me' : '' }}">
                    
                    @if($msg->user_id != auth()->id())
                        <div class="avatar" onclick="openPrivateChat({{ $msg->user->id }})"  style="cursor:pointer">
                            <img src="{{ $msg->user->getFirstMediaUrl('user-image') ?: asset('assets/user-admin-assets/img/default-user.png') }}">
                        </div>
                    @endif


                    <div class="message-bubble">
                        @if($msg->user_id != auth()->id())
                            <div class="message-user" onclick="openPrivateChat({{ $msg->user->id }})"  style="cursor:pointer">{{ $msg->user->name }}</div>
                        @endif
                        {!! $msg->message !!}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- INPUT -->
        <div class="chat-input">
            <textarea id="communityInput" rows="1" placeholder="Type your message…"></textarea>
            <button id="sendCommunity">Send</button>
        </div>

    </div>

    <div id="private-chat-box" class="community-content">
        <!-- Private chat will load here -->
    </div>

    <!-- MEMBERS -->
    <div id="tab-members" class="community-content chat-area">

    </div>


    <!-- REQUESTS -->
    <div id="tab-requests" class="community-content">
        @forelse($chats as $chat)
            @php
                $user = $chat->otherUser();
                $lastMsg = $chat->messages->first();
            @endphp

            <div class="member-item" onclick="openPrivateChat({{ $user->id }})">

                <div style="display:flex;gap:10px;align-items:center">
                    <div class="avatar">
                        <img src="{{ $msg->user->getFirstMediaUrl('user-image') ?: asset('assets/user-admin-assets/img/default-user.png') }}">
                    </div>

                    <div>
                        <div style="font-weight:600">{{ $user->name }}</div>

                        <small class="text-muted">
                            {{ $lastMsg?->message ?? 'No messages yet' }}
                        </small>
                    </div>
                </div>

                <small class="text-muted">
                    {{ optional($lastMsg)->created_at?->diffForHumans() }}
                </small>

            </div>
        @empty
            <div class="p-3 text-center text-muted">
                No chats yet
            </div>
        @endforelse
    </div>

</div>

@endsection


@section('script')
<script>
window.onload = function () {
    const chatMessages = document.getElementById('chatMessages'); // use your actual ID
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
};
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    fetch('/community/members')
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                let container = document.getElementById('tab-members');
                container.innerHTML = '';

                data.members.forEach(member => {
                    let avatar = member.avatar && member.avatar !== 'null'
                        ? member.avatar
                        : '/assets/user-admin-assets/img/default-user.png';

                    container.innerHTML += `
                        <div class="member-row">
                            <div class="avatar" onclick="openPrivateChat(${member.id})" style="cursor:pointer">
                                <img src="${avatar}">
                            </div>
                            <span class="member-name" onclick="openPrivateChat(${member.id})" style="cursor:pointer">
                                ${member.name}
                            </span>
                        </div>
                    `;
                });
            }
        });
});
</script>


<script>
function switchTab(tab){
    document.querySelectorAll('.community-tab').forEach(t=>t.classList.remove('active'));
    document.querySelectorAll('.community-content').forEach(c=>c.classList.remove('active'));

    document.querySelector(`[onclick="switchTab('${tab}')"]`).classList.add('active');
    document.getElementById(`tab-${tab}`).classList.add('active');
}

/* SEND MESSAGE */
// sendCommunity.onclick = () => {
//     fetch("{{ route('community.send') }}",{
//         method:'POST',
//         headers:{
//             'X-CSRF-TOKEN':'{{ csrf_token() }}',
//             'Content-Type':'application/json'
//         },
//         body:JSON.stringify({ message: communityInput.value })
//     }).then(()=> communityInput.value='');
// };

sendCommunity.onclick = () => {

    const message = communityInput.value.trim();
    if (!message) return;

    /* 1️⃣ SHOW MESSAGE IN UI IMMEDIATELY (RIGHT SIDE) */
    chatMessages.innerHTML += `
        <div class="message-row me">
            <div class="message-bubble">
                ${message}
            </div>
        </div>
    `;
    chatMessages.scrollTop = chatMessages.scrollHeight;

    communityInput.value = '';

    /* 2️⃣ SEND TO SERVER */
    fetch("{{ route('community.send') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ message })
    });
};

/* REALTIME */
// Echo.channel('community.global')
// .listen('.CommunityMessageSent', e => {
//     chatMessages.innerHTML += `
//         <div class="message-row">
//             <div class="avatar"></div>
//             <div class="message-bubble">
//                 <div class="message-user">${e.message.user.name}</div>
//                 ${e.message.message}
//             </div>
//         </div>
//     `;
//     chatMessages.scrollTop = chatMessages.scrollHeight;
// });

/* PRIVATE CHAT */
function requestChat(id){
    fetch(`/community/chat/request/${id}`);
}
</script>

<script>
(function waitForEcho() {

    if (typeof window.Echo === 'undefined') {
        setTimeout(waitForEcho, 50);
        return;
    }

    console.log('Echo ready ✅');

    window.Echo.channel('community.global')
        .listen('.CommunityMessageSent', (e) => {

            chatMessages.innerHTML += `
                <div class="message-row">
                    <div class="avatar" onclick="openPrivateChat({{ $msg->user->id }})"  style="cursor:pointer"><img src="${e.message.avatar}"></div>
                    <div class="message-bubble">
                        <div class="message-user" onclick="openPrivateChat({{ $msg->user->id }})"  style="cursor:pointer">${e.message.user.name}</div>
                        ${e.message.message}
                    </div>
                </div>
            `;

            chatMessages.scrollTop = chatMessages.scrollHeight;
        });

    })();
</script>
<script>
    function updateChatStatus(chatId, status) {
        fetch(`/community/chat/${chatId}/status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ status })
        })
        .then(() => location.reload());
    }
    function openChat(chatId) {
        fetch(`/community/chat/${chatId}`)
            .then(res => res.text())
            .then(html => {
                document.getElementById('tab-community').innerHTML = html;
                switchTab('community');
            });
    }

</script>

{{-- private chat --}}
<script>
    function openPrivateChat(userId) {
        fetch(`/community/chat/with/${userId}`)
            .then(res => res.text())
            .then(html => {
                document.getElementById('tab-community').classList.remove('active');
                document.getElementById('tab-requests').classList.remove('active');
                document.getElementById('private-chat-box').classList.add('active');
                document.getElementById('private-chat-box').innerHTML = html;
            });
    }

    function backToCommunity() {
        document.getElementById('private-chat-box').classList.remove('active');
        document.getElementById('tab-community').classList.add('active');
    }

    function sendPrivateMessage(chatId) {
        const input = document.getElementById('privateMessageInput');
        const message = input.value.trim();
        if (!message) return;

        // UI instant add
        document.getElementById('privateChatMessages').innerHTML += `
            <div class="message-row me">
                <div class="message-bubble">${message}</div>
            </div>
        `;

        input.value = '';
        document.getElementById('privateChatMessages').scrollTop =
            document.getElementById('privateChatMessages').scrollHeight;

        fetch(`/community/chat/${chatId}/send`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ message })
        });
    }

</script>

@endsection

