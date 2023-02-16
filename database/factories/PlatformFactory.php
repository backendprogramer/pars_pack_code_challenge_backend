<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Platform>
 */
class PlatformFactory extends Factory
{
    private array $platform= ['IOS', 'Android'];
    private array $responseText= ['IOS' => 'subscription', 'Android' => 'status'];
    private array $delayHour= ['IOS' => 2, 'Android' => 1];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $platformName = $this->getUniqueName();
        return [
            'name' => $platformName,
            'slug' => getUrl($platformName),
            'description' => fake()->text(),
            'image' => fake()->imageUrl(),
            'response_text' => $this->responseText[$platformName],
            'delay_hour' => $this->delayHour[$platformName],
            'admin_id' => User::all()->random()->id,
        ];
    }

    /**
     * Get unique name from platform array
     *
     * @return string
     */
    private function getUniqueName(): string {
        static $usedNames = [];
        do {
            $keyPlatform = array_rand($this->platform);
            $platformName = $this->platform[$keyPlatform];
        } while (in_array($platformName, $usedNames));
        $usedNames[] = $platformName;
        return $platformName;
    }
}
