<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 1;
        while($count <= 5){
            User::create([
                'name' => "DEV$count",
                'can_work_size' => $count
            ]);

            $count++;
        }
    }
}
