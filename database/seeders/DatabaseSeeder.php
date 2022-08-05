<?php

namespace Database\Seeders;

use App\Models\User;
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
         User::factory(1)->create();
         \App\Models\Skill::create([
            'name' => 'Vue js'
         ]);
         \App\Models\Skill::create([
            'name' => 'Nuxt js'
         ]);
         \App\Models\Skill::create([
            'name' => 'Laravel'
         ]);
    }
}
