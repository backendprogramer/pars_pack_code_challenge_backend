<?php

namespace App\Http\Controllers;

use App\Events\ChangeStatus;
use App\Jobs\CheckSubscriptionLater;
use App\Models\App;
use App\Models\AppPlatformSubscription;
use App\Models\Platform;
use App\Models\User;
use App\Models\UserAppSubscription;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function PHPUnit\Framework\throwException;

class SubscriptionServiceController extends Controller
{
    /**
     * Check status of User in  App or App in  App Store.
     */
    public function checkSubscription(Platform $platform, App $app, User $user = null): JsonResponse
    {
        try {
            //throw new \ErrorException('test');     uncomment for test job CheckSubscriptionLater
            if(isset($user)) { //Check status of User in  App
                if(isset($app->getUserAppSubscriptions)) {
                    $existUserInApp = $app->getUserAppSubscriptions->where('user_id', $user->id)->first();
                    return $this->checkSubscriptionStatus($existUserInApp, $platform, 'this User does not exist in App', $app, $user);
                }
                return response()->json(['status' => 'error' , 'message' => 'this User does not exist in App'],404);
            }
            //Check status of App in  App Store
            if(isset($platform->getAppPlatformSubscriptions)) {
                $existAppInAppStore = $platform->getAppPlatformSubscriptions->where('app_id', $app->id)->first();
                return $this->checkSubscriptionStatus($existAppInAppStore, $platform, 'this App does not exist in App Store', $app);
            }
            return response()->json(['status' => 'error' , 'message' => 'this App does not exist in App Store'],404);
        } catch (\Exception $exception) {
            dispatch(new CheckSubscriptionLater($platform->slug, $app->slug, $user->id ?? null))->delay(60 * 60 * $platform->delay_hour);
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()],500);
        }
    }

    private function checkSubscriptionStatus($existData, $platform, $errorMessage, $app, $user = null): JsonResponse
    {
        if(isset($existData)) {
            if($existData->expire_date < now()) {
                $existData->update(['status', 2]); //Expired
            }
            event(new ChangeStatus($platform,$app,$user));
            return response()->json([$platform->response_text => $existData->getStatus()]);
        }
        return response()->json(['status' => 'error' , 'message' => $errorMessage], 404);
    }


    /**
     * Get last lines of report weekly logs.
     */
    public function showLastRecordOfScheduleWeekend(int $numberWeeks = 1): JsonResponse
    {
        try {
            if(!is_numeric($numberWeeks) || $numberWeeks <= 0) {
                throw new \InvalidArgumentException('input must be numeric and positive');
            }
            $file = storage_path("logs\\report_change_status.log");
            $data = file($file);
            if(count($data)-$numberWeeks >= 0) {
                $line = $data[count($data)-$numberWeeks];
            }
            if(empty($line)) {
                $line = 'report file is empty';
            }
            return response()->json(['status' => 'success', 'records' => $line]);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()],500);
        }
    }
}
