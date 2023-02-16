<?php

namespace App\Console\Commands;

use App\Events\ChangeStatus;
use App\Models\AppPlatformSubscription;
use App\Models\UserAppSubscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check status user in app and app in app store';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        ChangeStatus::$countAppChange = 0;
        ChangeStatus::$countUserChange = 0;
        $appPlatforms = AppPlatformSubscription::with('getPlatform.getAdmin','getApp')->where('status', 1)->get();
        foreach ($appPlatforms as $appPlatform) {
            app('App\Http\Controllers\SubscriptionServiceController')->checkSubscription($appPlatform->getPlatform, $appPlatform->getApp);
        }

        $userApps = UserAppSubscription::with('getApp.getAdmin', 'getApp.getPlatforms', 'getUser')->where('status', 1)->get();
        foreach ($userApps as $userApp) {
            foreach ($userApp->getApp->getPlatforms as $platform) {
                app('App\Http\Controllers\SubscriptionServiceController')->checkSubscription($platform, $userApp->getApp, $userApp->getUser);
            }
        }

        Log::channel('report_change_status')->Info('Schedule Weekend run and ' . ChangeStatus::$countAppChange . ' App and ' . ChangeStatus::$countUserChange . ' User changed status to Expired');
    }
}
