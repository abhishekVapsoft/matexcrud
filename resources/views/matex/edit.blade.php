@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit User</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('matex.index') }}"> Back</a>
            </div>
        </div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('matex.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Add this line for PUT method -->
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" class="form-control" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}"
                required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="form-group">
            <label for="mobile">Mobile:</label>
            <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $user->mobile) }}" required>
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" class="form-control" value="{{ old('dob', $user->dob) }}" required>
        </div>
        <div class="form-group">
            <label>Gender:</label><br>
            @foreach ($genders as $gender)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender_id" value="{{ $gender->id }}"
                        {{ $user->gender_id == $gender->id ? 'checked' : '' }} required>
                    <label class="form-check-label">{{ $gender->name }}</label>
                </div>
            @endforeach
        </div>
        <div class="form-group">
            <label for="education">Education Level:</label>
            <select name="education_id" class="form-control" required>
                @foreach ($educations as $education)
                    <option value="{{ $education->id }}" {{ $user->education_id == $education->id ? 'selected' : '' }}>
                        {{ $education->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Hobbies:</label><br>
            @foreach ($hobbies as $hobby)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="hobbies[]" value="{{ $hobby->id }}"
                        {{ $user->hobbies->contains($hobby->id) ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $hobby->name }}</label>
                </div>
            @endforeach
        </div>
        <div class="form-group">
            <label for="file">Certificates:</label>
            <input type="file" name="certificate[]" class="form-control" multiple>
            @if ($user->certificate)
                <h5>Existing Certificates:</h5>
                @foreach (json_decode($user->certificate) as $certificate)
                    <div>
                        <a href="{{ asset('uploads/certificates/' . $certificate) }}"
                            target="_blank">{{ $certificate }}</a>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="form-group">
            <label for="profile_info">Profile Info (JSON):</label>
            <textarea name="profile_info" class="form-control" placeholder='Enter Your Bio...' rows="4">{{ old('profile_info', $user->profile_info) }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
@endsection
