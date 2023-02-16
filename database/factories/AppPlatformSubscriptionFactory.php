<?php

namespace Database\Factories;

use App\Models\AppPlatformSubscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppPlatformSubscription>
 */
class AppPlatformSubscriptionFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statusKey = array_rand(AppPlatformSubscription::$STATUS);
        return [
            'status' => $statusKey,
            'expire_date' => getExpireDateByStatus($statusKey)
        ];
    }

}
