<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Здесь регистрируются каналы для broadcasting.
| Определяем, кто имеет доступ к private каналам.
|
*/

// Пример стандартного канала user
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Канал для синхронизации интеграции
Broadcast::channel('integration.{integrationId}', function ($user, $integrationId) {

    // Если один admin — можно просто вернуть true
    return true;

    // Более правильный вариант:
    // return $user->is_admin === true;

    // Или если будут несколько пользователей:
    // return Integration::where('id', $integrationId)
    //     ->where('user_id', $user->id)
    //     ->exists();
});
