<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hobby;
use App\Models\Gender;
use App\Models\Education;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends Controller
{

    public function index()
    {
        // Fetch users along with their hobbies, gender, and education
        $users = User::with(['hobbies', 'gender', 'education'])->get();
        return view('matex.index', compact('users'));
    }

    public function create()
    {
        // Retrieve all educations, genders, and hobbies for the create form
        $educations = Education::all();
        $genders = Gender::all();
        $hobbies = Hobby::all();
        return view('matex.create', compact('educations', 'genders', 'hobbies'));
    }

    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|string|max:15|unique:users',
            'dob' => 'required|date',
            'password' => 'required|string|min:8|confirmed',
            'gender_id' => 'required|exists:genders,id',
            'education_id' => 'required|exists:educations,id',
            'hobbies' => 'array', // Hobbies as an array
            'profile_info' => 'required',
            'certificate' => 'array', // Ensure certificate is treated as an array
            'certificate.*' => 'required',
        ]);

        $fileNames = [];

        // Handle file uploads for certificates
        if ($request->hasFile('certificate')) {
            foreach ($request->file('certificate') as $file) {
                $fileName = time() . rand(1, 99) . '.' . $file->extension();
                $file->move(public_path('uploads/certificates'), $fileName);

                $fileNames[] = $fileName; // Store each file name in the array
            }
        }

        // Create the user with validated data
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'dob' => $request->dob,
            'gender_id' => $request->gender_id,
            'education_id' => $request->education_id,
            'hobbie_ids' => json_encode($request->hobbies), // Save hobbies as JSON
            'certificate' => json_encode($fileNames), // Save certificate paths as JSON
            'profile_info' => json_encode($request->profile_info), // Assuming profile_info is JSON formatted
            'password' => bcrypt($request->password), // Hashing password
        ]);

        // Attach hobbies to the user in the pivot table
        if ($request->has('hobbies')) {
            $user->hobbies()->attach($request->hobbies);
        }

        return redirect()->route('matex.index')->with('success', 'User created successfully!');
    }

    public function edit(Request $request, $id)
    {
        // Fetch the user along with their related models for editing
        $user = User::with(['hobbies', 'gender', 'education'])->findOrFail($id);
        $educations = Education::all();
        $genders = Gender::all();
        $hobbies = Hobby::all();

        return view('matex.edit', compact('user', 'educations', 'genders', 'hobbies'));
    }

    public function update(Request $request, $id)
    {
        // Validate request data for update
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'mobile' => 'required|string|max:15|unique:users,mobile,' . $id,
            'dob' => 'required|date',
            'gender_id' => 'required|exists:genders,id',
            'education_id' => 'required|exists:educations,id',
            'hobbies' => 'array', // Hobbies as an array
            'profile_info' => 'required',
            'certificate' => 'array', // Ensure certificate is treated as an array
            'certificate.*' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $user = User::findOrFail($id);

        // Get existing certificates
        $existingCertificates = json_decode($user->certificate, true) ?? [];

        // Handle file uploads for certificates
        if ($request->hasFile('certificate')) {
            foreach ($request->file('certificate') as $file) {
                $fileName = time() . rand(1, 99) . '.' . $file->extension();
                $file->move(public_path('uploads/certificates'), $fileName);
                $existingCertificates[] = $fileName; // Append new certificate
            }
        }

        // Update user information
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'dob' => $request->dob,
            'gender_id' => $request->gender_id,
            'education_id' => $request->education_id,
            'hobbie_ids' => json_encode($request->hobbies), // Update hobbies
            'certificate' => json_encode($existingCertificates), // Keep existing certificates and append new ones
            'profile_info' => json_encode($request->profile_info), // Assuming profile_info is JSON formatted
        ]);

        // Update hobbies in the pivot table
        if ($request->has('hobbies')) {
            // Sync hobbies: attach new hobbies and detach the ones not in the request
            $user->hobbies()->sync($request->hobbies);
        } else {
            // If no hobbies are provided, detach all hobbies
            $user->hobbies()->detach();
        }

        return redirect()->route('matex.index')->with('success', 'User updated successfully!');
    }

    public function destroy(Request $request)
    {
        // Retrieve the IDs of users to delete
        $ids = $request->input('ids');

        if ($ids && is_array($ids)) {
            // Delete users by IDs
            User::destroy($ids);
            return redirect()->route('matex.index')->with('success', 'Users deleted successfully.');
        }

        return redirect()->route('matex.index')->with('error', 'No users selected for deletion.');
    }

    public function importView()
    {
        return view('matex.import'); // Ensure you have a view file named import.blade.php
    }

    public function import(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
        ]);

        // Read the file and import
        $data = Excel::toArray(new UsersImport, $request->file('file'));

        // Get the data from the first sheet
        $previewData = $data[0];

        return view('matex.preview', compact('previewData'));
    }


    public function importSubmit(Request $request)
    {
        // Validate request data
        $request->validate([
            'selected_rows' => 'required|array',
        ]);
    
        // Fetch IDs based on names
        $genders = Gender::pluck('id', 'name')->toArray();
        $educations = Education::pluck('id', 'name')->toArray();
        $hobbies = Hobby::pluck('id', 'name')->toArray();
    
        foreach ($request->selected_rows as $rowJson) {
            $row = json_decode($rowJson, true);
    
            // Ensure 'dob' is available and convert from Excel format
            if (isset($row['dob'])) {
                $dob = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['dob'])->format('Y-m-d');
            } else {
                $dob = null; // Handle the case where dob is missing
            }
    
            // Map names to IDs
            $genderId = $genders[$row['gender']] ?? null;
            $educationId = $educations[$row['education']] ?? null;
            
            // Create the user
            $user = User::create([
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email'],
                'mobile' => $row['mobile'],
                'dob' => $dob,
                'gender_id' => $genderId,
                'education_id' => $educationId,
                'profile_info' => json_encode($row['profile_info']),
                'certificate' => json_encode([]), // Handle certificates if needed
                'password' => bcrypt('defaultpassword'), // Or handle password if available
            ]);
    
            // Attach hobbies to the user
            if (!empty($row['hobbies'])) {
                $hobbyNames = explode(', ', $row['hobbies']);
                $hobbyIds = [];
    
                foreach ($hobbyNames as $name) {
                    $hobbyId = $hobbies[$name] ?? null;
                    if ($hobbyId) {
                        $hobbyIds[] = $hobbyId;
                    }
                }
    
                // Attach hobbies using the pivot table
                $user->hobbies()->attach($hobbyIds);
            }
        }
    
        return redirect()->route('matex.index')->with('success', 'Users imported successfully!');
    }
    
    
}
