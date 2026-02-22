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
        
        -webkit-user-select: none;
        user-select: none;
        -webkit-touch-callout: none; /* disables magnifier */
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

<style>
    .reply-preview {
        background: #0f172a;
        border-left: 4px solid #22c55e;
        padding: 8px;
        margin: 5px;
        border-radius: 8px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        font-size: 13px;
    }
    
    .reply-box {
        background: #020617;
        border-left: 3px solid #22c55e;
        padding: 5px;
        font-size: 12px;
        margin-bottom: 4px;
        border-radius: 5px;
        cursor:pointer;
    }
    
    .msg-time {
        font-size: 11px;
        color: #94a3b8;
        float: right;
        margin-top: 8px;
        margin-left: 5px;
    }

    .deleted-msg {
        color: #94a3b8;
        font-style: italic;
        font-size: 13px;
    }
    
    .msg-context-menu {
        position: absolute;
        background: #0f172a;
        border-radius: 8px;
        padding: 6px;
        display: none;
        z-index: 9999;
    }
    
    .msg-context-menu button {
        display: block;
        background: none;
        color: white;
        border: none;
        padding: 6px 12px;
        width: 100%;
        text-align: left;
    }

</style>
@endsection


@section('content')

<div class="community-container">

    <!-- TABS -->
    <div class="community-tabs">
        <div class="community-tab active" onclick="switchTab('community')">Community</div>
        <div class="community-tab" onclick="switchTab('requests')">Messages</div>
        {{--<div class="community-tab" onclick="switchTab('members')">Members</div>--}}
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


                    {{--<div class="message-bubble">
                        @if($msg->user_id != auth()->id())
                            <div class="message-user" onclick="openPrivateChat({{ $msg->user->id }})"  style="cursor:pointer">{{ $msg->user->name }}</div>
                        @endif
                        {!! $msg->message !!}
                        
                        <small class="msg-time">
                            {{ $msg->created_at->format('h:i a') }}
                        </small>
                    </div>--}}
                    
                    <div class="message-bubble"
                     data-id="{{ $msg->id }}"
                     data-user="{{ $msg->user->name }}"
                     data-text="{{ Str::limit(strip_tags($msg->message), 50) }}"
                     oncontextmenu="replyToMessage({{ $msg->id }}, '{{ $msg->user->name }}', `{{ Str::limit(strip_tags($msg->message), 50) }}`); return false;">
                    @if($msg->user_id != auth()->id())
                            <div class="message-user" onclick="openPrivateChat({{ $msg->user->id }})"  style="cursor:pointer">{{ $msg->user->name }}</div>
                        @endif
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
                </div>
            @endforeach
        </div>
        
        <div id="replyPreviewcommunity" class="reply-preview" style="display:none;">
            <div>
                <small id="replyUsercommunity"></small>
                <div id="replyTextcommunity"></div>
            </div>
            <button class="btn" onclick="cancelReply()">✕</button>
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
    let replyToId = null;
    
    let selectedMsgId = null;

    function openMsgMenu(e, id, isMine) {
        e.preventDefault();
    
        selectedMsgId = id;
    
        const menu = document.getElementById('msgContextMenu');
    
        // Show delete only for own message
        document.getElementById('deleteBtn').style.display =
            isMine ? 'block' : 'none';
    
        menu.style.left = e.pageX + 'px';
        menu.style.top = e.pageY + 'px';
        menu.style.display = 'block';
    }
    
    document.addEventListener('click', () => {
        document.getElementById('msgContextMenu').style.display = 'none';
    });
    
    function doReply() {
        const row = document.getElementById('msg-' + selectedMsgId);
    
        if (!row) return;
    
        // Get the bubble inside this row
        const bubble = row.querySelector('.message-bubble');
    
        if (!bubble) return;
    
        replyToMessage(
            selectedMsgId,
            bubble.dataset.user,
            bubble.dataset.text
        );
    
        hideMenu();
    }

    
    function doDelete() {
        deleteMessage(selectedMsgId);
        hideMenu();
    }
    
    function hideMenu() {
        document.getElementById('msgContextMenu').style.display = 'none';
    }


    function replyToMessage(id, user, text) {
        replyToId = id;
        document.getElementById('replyPreview').style.display = 'flex';
        document.getElementById('replyUser').innerText = user;
        document.getElementById('replyText').innerText = text;
    }
    
    function cancelReply() {
        replyToId = null;
        document.getElementById('replyPreview').style.display = 'none';
    }
    
    function scrollToMessage(id) {
        const el = document.getElementById('msg-' + id);
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            el.style.background = '#1e293b';
            setTimeout(() => el.style.background = '', 1500);
        }
    }
    
    function attachLongPress(el, id, user, text) {
        let pressTimer;
    
        el.addEventListener('touchstart', (e) => {
            e.preventDefault(); // 🔥 stops magnifier & text select
            pressTimer = setTimeout(() => {
                replyToMessage(id, user, text);
            }, 500);
        }, { passive: false }); // ⚠️ important
    
        el.addEventListener('touchend', () => {
            clearTimeout(pressTimer);
        });
    
        el.addEventListener('touchcancel', () => {
            clearTimeout(pressTimer);
        });
    
        el.addEventListener('touchmove', () => {
            clearTimeout(pressTimer);
        });
    }



</script>

<script>
    
const authUserId = {{ auth()->id() }};

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
    const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });
    if (!message) return;
    
    
    let replyHTML = '';
    
    if (replyToId) {
        const replyUser = document.getElementById('replyUser').innerText;
        const replyText = document.getElementById('replyText').innerText;

        replyHTML = `
            <div class="reply-box">
                <small>${replyUser}</small>
                <div>${replyText}</div>
            </div>
        `;
    }

    /* 1️⃣ SHOW MESSAGE IN UI IMMEDIATELY (RIGHT SIDE) */
    chatMessages.innerHTML += `
        <div class="message-row me">
            <div class="message-bubble">
                ${replyHTML}
                ${message}
                <small class="msg-time">${time}</small>
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
        body: JSON.stringify({
            message,
            reply_to_id: replyToId
        })
    });
    
    cancelReply();
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

    window.echoInstance
        .channel('community.global')
        .listen('.CommunityMessageSent', (e) => {

            if (e.message.user_id === authUserId) {
                return;
            }
            
            const msgId = e.message.id;
            const user = e.message.user.name;
            const text = e.message.message.replace(/(<([^>]+)>)/gi, "").substring(0, 50);
            
            let replyHTML = '';

            if (e.message.reply) {
                replyHTML = `
                    <div class="reply-box" onclick="scrollToMessage(${e.message.reply.id})">
                        <small>${e.message.reply.user}</small>
                        <div>${e.message.reply.text}</div>
                    </div>
                `;
            }
            

            chatMessages.innerHTML += `
                <div class="message-row" id="msg-${msgId}">
                    <div class="avatar" onclick="openPrivateChat(${e.message.user_id})" style="cursor:pointer">
                        <img src="${e.message.avatar}" />
                    </div>
                    <div class="message-bubble" oncontextmenu="replyToMessage(${msgId}, '${user}', \`${text}\`); return false;">
                        <div class="message-user" onclick="openPrivateChat(${e.message.user_id})" style="cursor:pointer">
                            ${e.message.user.name}
                        </div>
                        ${replyHTML}
                        <div class="message-text">
                            ${e.message.message}
                        </div>
                        <small class="msg-time">${e.message.time}</small>
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
    // function openPrivateChat(userId) {
    //     fetch(`/community/chat/with/${userId}`)
    //         .then(res => res.text())
    //         .then(html => {
    //             document.getElementById('tab-community').classList.remove('active');
    //             document.getElementById('tab-requests').classList.remove('active');
    //             document.getElementById('private-chat-box').classList.add('active');
    //             document.getElementById('private-chat-box').innerHTML = html;
    //         });
    // }
    
    let currentPrivateChatId = null;

    function openPrivateChat(userId) {
        fetch(`/community/chat/with/${userId}`)
            .then(res => res.text())
            .then(html => {
                document.getElementById('tab-community').classList.remove('active');
                document.getElementById('tab-requests').classList.remove('active');
                document.getElementById('private-chat-box').classList.add('active');
                document.getElementById('private-chat-box').innerHTML = html;
    
                setTimeout(() => {
                    const chatBox = document.getElementById('privateChatBox');
                    if (!chatBox) return;
    
                    const chatId = chatBox.dataset.chatId;
                    if (chatId) {
                        currentPrivateChatId = chatId;
                        listenPrivateChat(chatId);
                    }
                }, 200);
            });
    }



    function backToCommunity() {
        document.getElementById('private-chat-box').classList.remove('active');
        document.getElementById('tab-community').classList.add('active');
    }

    // function sendPrivateMessage(chatId) {
    //     const input = document.getElementById('privateMessageInput');
    //     const message = input.value.trim();
    //     const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });
    //     if (!message) return;
    
    //     let replyHTML = '';
    
    //     if (replyToId) {
    //         const replyUser = document.getElementById('replyUser').innerText;
    //         const replyText = document.getElementById('replyText').innerText;
    
    //         replyHTML = `
    //             <div class="reply-box">
    //                 <small>${replyUser}</small>
    //                 <div>${replyText}</div>
    //             </div>
    //         `;
    //     }
    
    //     // UI instant add
    //     document.getElementById('privateChatMessages').innerHTML += `
    //         <div class="message-row me">
    //             <div class="message-bubble">
    //                 ${replyHTML}
    //                 ${message}
    //                 <small class="msg-time">${time}</small>
    //             </div>
    //         </div>
    //     `;
    
    //     input.value = '';
    //     document.getElementById('privateChatMessages').scrollTop =
    //         document.getElementById('privateChatMessages').scrollHeight;
    
    //     fetch(`/community/chat/${chatId}/send`, {
    //         method: 'POST',
    //         headers: {
    //             'X-CSRF-TOKEN': '{{ csrf_token() }}',
    //             'Content-Type': 'application/json'
    //         },
    //         body: JSON.stringify({
    //             message,
    //             reply_to_id: replyToId
    //         })
    //     });
    
    //     // reset reply state
    //     cancelReply();
    // }

    
    // function listenPrivateChat(chatId) {

    //     if (window.privateEchoChannel) {
    //         window.privateEchoChannel.stopListening('.PrivateMessageSent');
    //     }
        
    //     window.privateEchoChannel = window.echoInstance.private(`private.chat.${chatId}`)
    //         .listen('.PrivateMessageSent', (e) => {
    
    //             if (e.message.user_id === authUserId) return;
    
    //             let msgBox = document.getElementById('privateChatMessages');
    
    //             // msgBox.innerHTML += `
    //             //     <div class="message-row">
    //             //         <div class="avatar">
    //             //             <img src="${e.message.avatar}">
    //             //         </div>
    //             //         <div class="message-bubble">
    //             //             ${e.message.message}
    //             //         </div>
    //             //     </div>
    //             // `;
                
    //             const msgId = e.message.id;
    //             const user = e.message.user.name;
    //             const text = e.message.message.replace(/(<([^>]+)>)/gi, "").substring(0, 50);
                
    //             let replyHTML = '';

    //             if (e.message.reply) {
    //                 replyHTML = `
    //                     <div class="reply-box" onclick="scrollToMessage(${e.message.reply.id})">
    //                         <small>${e.message.reply.user}</small>
    //                         <div>${e.message.reply.text}</div>
    //                     </div>
    //                 `;
    //             }

    //             msgBox.innerHTML += `
    //                 <div class="message-row" id="msg-${msgId}">
    //                     <div class="avatar">
    //                         <img src="${e.message.avatar}">
    //                     </div>
    //                     <div class="message-bubble"
    //                         oncontextmenu="replyToMessage(${msgId}, '${user}', \`${text}\`); return false;">
    //                         ${replyHTML}
    //                         ${e.message.message}
    //                         <small class="msg-time">${e.message.time}</small>
    //                     </div>
    //                 </div>
    //             `;
    
    //             msgBox.scrollTop = msgBox.scrollHeight;
    //         });
    // }
    
    function sendPrivateMessage(chatId) {

        const input = document.getElementById('privateMessageInput');
        const message = input.value.trim();
    
        if (!message) return;
    
        const time = new Date().toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        });
    
        // Temp id for UI
        const tempId = 'temp-' + Date.now();
    
        let replyHTML = '';
    
        if (replyToId) {
            const replyUser = document.getElementById('replyUser').innerText;
            const replyText = document.getElementById('replyText').innerText;
    
            replyHTML = `
                <div class="reply-box">
                    <small>${replyUser}</small>
                    <div>${replyText}</div>
                </div>
            `;
        }
    
        // Instant UI add (FULL FORMAT)
        document.getElementById('privateChatMessages').innerHTML += `
            <div class="message-row me" id="msg-${tempId}">
                <div class="message-bubble"
                     data-id="${tempId}"
                     data-user="You"
                     data-text="${message.substring(0,50)}">
    
                    <div class="msg-menu"
                         oncontextmenu="openMsgMenu(event, '${tempId}', true); return false;">
    
                        ${replyHTML}
                        ${message}
    
                        <small class="msg-time">${time}</small>
    
                    </div>
                </div>
            </div>
        `;
    
        input.value = '';
    
        const box = document.getElementById('privateChatMessages');
        box.scrollTop = box.scrollHeight;
    
        // Send to server
        fetch(`/community/chat/${chatId}/send`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                message,
                reply_to_id: replyToId
            })
        });
    
        cancelReply();
    }
    
    function listenPrivateChat(chatId) {

        if (window.privateEchoChannel) {
            window.privateEchoChannel.stopListening('.PrivateMessageSent');
        }
    
        window.privateEchoChannel = window.echoInstance
            .private(`private.chat.${chatId}`)
    
            .listen('.PrivateMessageSent', (e) => {
    
                let msgBox = document.getElementById('privateChatMessages');
    
                const msgId = e.message.id;
                const user = e.message.user.name;
    
                const text = e.message.message
                    .replace(/(<([^>]+)>)/gi, "")
                    .substring(0, 50);
    
                /* ===============================
                   IF THIS IS MY OWN MESSAGE
                   → Replace temp ID
                =============================== */
    
                if (e.message.user_id === authUserId) {
    
                    const temp = document.querySelector('[id^="msg-temp-"]');
    
                    if (temp) {
    
                        temp.id = 'msg-' + msgId;
    
                        const bubble = temp.querySelector('.message-bubble');
    
                        bubble.dataset.id = msgId;
    
                        temp.querySelector('.msg-menu')
                            .setAttribute(
                                'oncontextmenu',
                                `openMsgMenu(event, ${msgId}, true); return false;`
                            );
                    }
    
                    return;
                }
    
    
                /* ===============================
                   OTHER USER MESSAGE
                =============================== */
    
                let replyHTML = '';
    
                if (e.message.reply) {
                    replyHTML = `
                        <div class="reply-box" onclick="scrollToMessage(${e.message.reply.id})">
                            <small>${e.message.reply.user}</small>
                            <div>${e.message.reply.text}</div>
                        </div>
                    `;
                }
    
                msgBox.innerHTML += `
                    <div class="message-row" id="msg-${msgId}">
    
                        <div class="avatar">
                            <img src="${e.message.avatar}">
                        </div>
    
                        <div class="message-bubble"
                             data-id="${msgId}"
                             data-user="${user}"
                             data-text="${text}">
    
                            <div class="msg-menu"
                                 oncontextmenu="openMsgMenu(event, ${msgId}, false); return false;">
    
                                ${replyHTML}
                                ${e.message.message}
    
                                <small class="msg-time">${e.message.time}</small>
    
                            </div>
                        </div>
                    </div>
                `;
    
                msgBox.scrollTop = msgBox.scrollHeight;
            })
            
            .listen('.MessageDeleted', (e) => {
                markMessageDeleted(e.messageId, e.time);
            });
    }



</script>
<script>
    const box = document.getElementById('privateChatMessages');
    if (box) {
        box.scrollTop = box.scrollHeight;
    }
</script>
<script>
    function deleteMessage(id) {
        fetch(`/community/message/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        
        const time = new Date().toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        });
    
        markMessageDeleted(id, time);
    }
    
    function markMessageDeleted(id, time) {
        const msg = document.getElementById('msg-' + id);
        if (!msg) return;
    
        msg.querySelector('.message-bubble').innerHTML =
            `<i class="deleted-msg">This message was deleted</i><small class="msg-time">${time}</small>`;
    }


</script>
@endsection

