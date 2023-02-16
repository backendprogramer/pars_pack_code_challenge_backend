<?php

namespace Database\Seeders;

use App\Models\AppPlatformSubscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (AppPlatformSubscription::$STATUS as $key => $value) {
            DB::table('status')->insert(['id'=> $key, 'name'=>$value]);
        }
    }
}
