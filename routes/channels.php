<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('channel-quanly', function($user){
    return $user->nhanvien->MaBoPhan === 1;
});

Broadcast::channel('channel-kythuat', function($user){
    return $user->nhanvien->MaBoPhan === 3;
});

