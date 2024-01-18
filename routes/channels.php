<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;

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

/**
 * Authorize a user to listen to the "App.Models.User.{id}" channel.
 *
 * @param  \App\Models\User  $user
 * @param  mixed  $id
 * @return bool
 */
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/**
 * Authorize a user to listen to the "transactions.{userId}" channel.
 *
 * @param  \App\Models\User  $user
 * @param  mixed  $userId
 * @return bool
 */
Broadcast::channel('transactions.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
