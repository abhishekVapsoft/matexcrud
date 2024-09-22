<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new User([
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'email' => $row['email'],
            'mobile' => $row['mobile'],
            'dob' => $row['dob'],
            'gender_id' => $row['gender_id'],
            'education_id' => $row['education_id'],
            'hobbie_ids' => json_encode($row['hobbies']),
            'profile_info' => json_encode($row['profile_info']),
            'password' => Hash::make($row['password']),
        ]);
    }
}
