<?php

namespace App\Listeners;

use App\Events\ChangeStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class sendMail implements ShouldQueue
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
    public function handle(ChangeStatus $event): void
    {
        if(isset($event->user)) {
            if(isset($event->app->getAdmin)) {
                $data = ['header' => 'change status User', 'body' => 'the status of User: ' . $event->user->id . ' changed to expired.'];
                $name = ($event->app->getAdmin->first_name ?? '') . ' ' . ($event->app->getAdmin->last_name ?? '');
                Mail::send('emails.statusEmail', $data, function ($message) use ($event, $name) {
                    $message->to($event->app->getAdmin->email, $name)->subject('Change Status User');
                    $message->from(env('MAIL_FROM_ADDRESS','info@appstore.com'), env('MAIL_FROM_NAME','send mail'));
                });
                Log::info('send email to admin app: ' .  $event->app->name);
                return;
            }
            Log::error('admin not set for app: ' .  $event->app->name);
            return;
        }
        if(isset($event->platform->getAdmin)) {
            $data = ['header' => 'change status App', 'body' => 'the status of App: ' . $event->app->id . ' changed to expired.'];
            $name = ($event->platform->getAdmin->first_name ?? '') . ' ' . ($event->platform->getAdmin->last_name ?? '');
            Mail::send('emails.statusEmail', $data, function ($message) use ($event, $name) {
                $message->to($event->platform->getAdmin->email, $name)->subject('Change Status App');
                $message->from('info@appstore.com', 'send mail');
            });
            Log::info('send email to admin platform: ' .  $event->app->name);
            return;
        }
        Log::error('admin not set for platform: ' .  $event->app->name);
    }
}
