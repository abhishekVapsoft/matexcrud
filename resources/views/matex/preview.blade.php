@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Preview Users</h2>
    <form action="{{ route('matex.import.submit') }}" method="POST">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>DOB</th>
                    <th>Gender</th>
                    <th>Education</th>
                    <th>Hobbies</th>
                    <th>Profile Info</th>
                </tr>
            </thead>
            <tbody>
                @foreach($previewData as $index => $row)
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_rows[]" value="{{ json_encode($row) }}">
                        </td>
                        <td>{{ $row['first_name'] }}</td>
                        <td>{{ $row['last_name'] }}</td>
                        <td>{{ $row['email'] }}</td>
                        <td>{{ $row['mobile'] }}</td>
                        <td>{{ $row['dob'] }}</td>
                        <td>{{ $row['gender'] }}</td>
                        <td>{{ $row['education'] }}</td>
                        <td>{{ $row['hobbies'] }}</td>
                        <td>{{ $row['profile_info'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Import Selected</button>
    </form>
</div>
@endsection
