<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HobbiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $createUserType = [
            ['id' => 1 , 'name'=> 'Listening Music', 'created_at' => now()],
            ['id' => 2 , 'name'=> 'Social Media', 'created_at' => now()],
            ['id' => 3 , 'name'=> 'Reading Books','created_at' => now()],
            ['id' => 4 , 'name'=> 'Movies','created_at' => now()],
            ['id' => 5 , 'name'=> 'Sports','created_at' => now()]
        ];
        
        DB::table('hobbies')->insert($createUserType);
    }
}
