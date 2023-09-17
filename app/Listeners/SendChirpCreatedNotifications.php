<?php

namespace App\Listeners;

use App\Events\ChirpCreated;
use App\Models\User;
use App\Models\UserFollow;
use App\Notifications\NewChirp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendChirpCreatedNotifications implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ChirpCreated $event): void
    {
        /*
        foreach (User::whereNot('id', $event->chirp->user_id)->cursor() as $user) {
            $user->notify(new NewChirp($event->chirp));
        }*/
        $users = UserFollow::where('followed_id', $event->chirp->user_id)->cursor()->map(function(UserFollow $userfollow){
            return User::find($userfollow->user_id);
        });
        foreach ($users as $user) {
            $user->notify(new NewChirp($event->chirp));
        }
    }
}
