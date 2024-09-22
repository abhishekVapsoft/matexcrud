@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Users</h2>
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
    <form action="{{ route('matex.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="mobile">Mobile:</label>
            <input type="text" name="mobile" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Gender:</label><br>
            @foreach ($genders as $gender)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender_id" value="{{ $gender->id }}" required>
                    <label class="form-check-label">{{ $gender->name }}</label>
                </div>
            @endforeach
        </div>
        <div class="form-group">
            <label for="education">Education Level:</label>
            <select name="education_id" class="form-control" required>
                @foreach ($educations as $education)
                    <option value="{{ $education->id }}">{{ $education->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Hobbies:</label><br>
            @foreach ($hobbies as $hobby)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="hobbies[]" value="{{ $hobby->id }}">
                    <label class="form-check-label">{{ $hobby->name }}</label>
                </div>
            @endforeach
        </div>
        <div class="form-group">
            <label for="file">Certificates:</label>
            <input type="file" name="certificate[]" class="form-control" multiple>
        </div>
        <div class="form-group">
            <label for="profile_info">Profile Info (JSON):</label>
            <textarea name="profile_info" class="form-control" placeholder='Enter Your Bio...' rows="4"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
@endsection
