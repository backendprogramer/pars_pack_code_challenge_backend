<?php

namespace Database\Seeders;

use App\Models\App;
use App\Models\AppPlatformSubscription;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppPlatformSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1; $i <= 5; $i++) {
            list($platformId, $appId) = $this->getUniqueData();
            AppPlatformSubscription::factory()->create([
                'platform_id' => $platformId,
                'app_id' => $appId,
            ]);
        }
    }

    /**
     * Get unique platform_id and app_id for insert data
     *
     * @return array
     */
    private function getUniqueData(): array {
        do {
            $platformId = Platform::all()->random()->id;
            $appId = App::all()->random()->id;
            $exist = AppPlatformSubscription::where('platform_id',$platformId)->where('app_id', $appId)->count();
        } while ($exist);

        return [$platformId, $appId];
    }
}
