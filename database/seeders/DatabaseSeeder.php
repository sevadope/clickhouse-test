<?php

namespace Database\Seeders;

use App\Models\Log;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            EventSeeder::class,
        );

        Log::factory(1000000)->create();
    }
}
