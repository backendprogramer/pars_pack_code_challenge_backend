<?php

namespace Tests\Feature\Http\Controllers;

use App\Events\ChangeStatus;
use App\Jobs\CheckSubscriptionLater;
use App\Models\AppPlatformSubscription;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\UserAppSubscription;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SubscriptionServiceControllerTest extends TestCase
{
//    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // Run the DatabaseSeeder
//        $this->seed();
    }


    /** @test
     * Get Api check status app in app store.
     */
    public function get_api_store_with_platform_app(): void
    {
        $data = AppPlatformSubscription::with('getPlatform', 'getApp')->first();
        $response = $this->json('GET', '/api/store/' . $data->getPlatform->slug . '/' . $data->getApp->slug);

        $response->assertStatus(200);
    }

    /** @test
     * Get Api check status app in app store error occurred.
     */
    public function get_api_store_with_platform_app_failed(): void
    {
        $data = AppPlatformSubscription::with('getPlatform', 'getApp')->first();
        $response = $this->json('GET', '/api/store/' . $data->getPlatform->slug . '/abc' );

        $response->assertStatus(404);
    }

    /** @test
     * Get Api check status user in app.
     */
    public function get_api_store_with_platform_app_user(): void
    {
        $data = UserAppSubscription::with( 'getApp.getPlatforms', 'getUser')->first();
        $responses = [];
        foreach ($data->getApp->getPlatforms as $platform) {
            $responses[] = $this->json('GET', '/api/store/' . $platform->slug . '/' . $data->getApp->slug . '/' . $data->getUser->id);
        }

        foreach ($responses as $response) {
            $response->assertStatus(200);
        }
    }

    /** @test
     * Get Api check status user in app error occurred.
     */
    public function get_api_store_with_platform_app_user_failed(): void
    {
        $data = UserAppSubscription::with( 'getApp.getPlatforms', 'getUser')->first();
        $responses = [];
        foreach ($data->getApp->getPlatforms as $platform) {
            $responses[] = $this->json('GET', '/api/store/' . $platform->slug . '/' . $data->getApp->slug . '/3232');
        }

        foreach ($responses as $response) {
            $response->assertStatus(404);
        }
    }

    /** @test
     * check show last record of schedule weekend
     */
    public function get_api_show_last_record_of_schedule_weekend(): void
    {
        $response = $this->json('GET', '/api/report/week/' . 1);
        $response->assertStatus(200);
    }

    /** @test
     * check error occurred in last record of schedule weekend
     */
    public function get_api_show_last_record_of_schedule_weekend_failed(): void
    {
        $response = $this->json('GET', '/api/report/week/abc');
        $response->assertStatus(500);
    }

    /** @test
     * Check job work when error occurred | note: uncomment throw ErrorException in checkSubscription methode for passed test.
     */
    public function get_api_store_with_platform_platform_app_failed_check_job(): void
    {
        Bus::fake();
        $data = AppPlatformSubscription::with('getPlatform', 'getApp')->first();
        $this->json('GET', '/api/store/' . $data->getPlatform->slug . '/' . $data->getApp->slug);
        Bus::assertDispatched(CheckSubscriptionLater::class);
    }

    /** @test
     * Check event faired.
     */
    public function get_api_store_with_platform_app_check_event(): void
    {
        Event::fake();
        $this->travel(1)->weeks();
        $data = AppPlatformSubscription::with('getPlatform', 'getApp')->first();
        $this->json('GET', '/api/store/' . $data->getPlatform->slug . '/' . $data->getApp->slug);
        Event::assertDispatched(ChangeStatus::class);
    }

    /** @test
     * Check command weekend worked
     */
    public function check_command_weekend(): void
    {
        Event::fake();
        $this->travel(1)->weeks();
        $this->artisan('check:status');
        Event::assertDispatched(ChangeStatus::class);
    }
}
