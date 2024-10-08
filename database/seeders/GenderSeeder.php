<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $createUserType = [
            ['id' => 1 , 'name'=> 'Female', 'created_at' => now()],
            ['id' => 2 , 'name'=> 'Male', 'created_at' => now()],
            ['id' => 3 , 'name'=> 'Transgender','created_at' => now()]
        ];
        
        DB::table('genders')->insert($createUserType);
    }
}
