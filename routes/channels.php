<?php

use Illuminate\Support\Facades\Broadcast;

if (!app()->runningInConsole()) {
    Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
        return (int) $user->id === (int) $id;
    });
}
