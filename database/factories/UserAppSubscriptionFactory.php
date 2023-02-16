<?php

namespace Database\Factories;

use App\Models\UserAppSubscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAppSubscription>
 */
class UserAppSubscriptionFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statusKey = array_rand(UserAppSubscription::$STATUS);
        return [
            'status' => $statusKey,
            'expire_date' => getExpireDateByStatus($statusKey)
        ];
    }
}
