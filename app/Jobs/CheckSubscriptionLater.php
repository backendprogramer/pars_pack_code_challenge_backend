<?php

namespace App\Jobs;

use GuzzleHttp\Exception\GuzzleException;
use http\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckSubscriptionLater implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $platform;
    private $app;
    private $user;

    /**
     * Create a new job instance.
     */
    public function __construct($platform, $app, $user = null)
    {
        $this->platform = $platform;
        $this->app = $app;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            sendRequest('GET', env('APP_URL', 'localhost:8000') . '/store/' . $this->platform
                . '/' . $this->app . (!empty($this->user) ? '/' . $this->user : ''));
        } catch (GuzzleException $exception) {
            Log::error('an error occurred in job CheckSubscriptionLater | error message: ' . $exception->getMessage());
        }
    }
}
