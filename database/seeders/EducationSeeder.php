<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $createUserType = [
            ['id' => 1 , 'name'=> 'SSLC', 'created_at' => now()],
            ['id' => 2 , 'name'=> 'Higher Secondary', 'created_at' => now()],
            ['id' => 3 , 'name'=> 'Graduates','created_at' => now()],
            ['id' => 4 , 'name'=> 'Postgraduates','created_at' => now()],
            ['id' => 5 , 'name'=> 'Others','created_at' => now()]
        ];
        
        DB::table('educations')->insert($createUserType);
    }
}
