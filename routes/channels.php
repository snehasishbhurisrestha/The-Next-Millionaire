<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('community.global', function () {
    return true;
});

Broadcast::channel('private.chat.{chatId}', function ($user, $chatId) {
    return true; // we'll secure later
});