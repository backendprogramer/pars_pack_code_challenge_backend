<?php

namespace Database\Seeders;

use App\Models\App;
use App\Models\User;
use App\Models\UserAppSubscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAppSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1; $i <= 10; $i++) {
            list($appId, $userId) = $this->getUniqueData();
            UserAppSubscription::factory()->create([
                'app_id' => $appId,
                'user_id' => $userId,
            ]);
        }
    }

    /**
     * Get unique app_id and user_id for insert data
     *
     * @return array
     */
    private function getUniqueData(): array {
        do {
            $appId = App::all()->random()->id;
            $userId = User::all()->random()->id;
            $exist = UserAppSubscription::where('user_id',$userId)->where('app_id', $appId)->count();
        } while ($exist);

        return [$appId, $userId];
    }
}
