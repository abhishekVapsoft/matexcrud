@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Laravel Excel Upload Example</h2>
            <div>
                <a class="btn btn-success" href="{{ route('matex.create') }}">Add User Details</a>
                <a class="btn btn-primary" href="{{ route('matex.import.view') }}">Excel Import</a>
            </div>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

<form action="{{ route('matex.destroy', '') }}" method="POST" id="delete-form">
    @csrf
    @method('DELETE')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th><input type="checkbox" id="select-all" onclick="toggle(this)"></th>
                        <th>No</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>DOB</th>
                        <th>Gender</th>
                        <th>Education</th>
                        <th>Hobbies</th>
                        <th>Certificates</th>
                        <th>Profile Info</th>
                        <th width="280px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr>
                            <td><input type="checkbox" class="user-checkbox" name="ids[]" value="{{ $user->id }}"></td>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->mobile }}</td>
                            <td>{{ $user->dob }}</td>
                            <td>{{ $user->gender->name ?? 'N/A' }}</td>
                            <td>{{ $user->education->name ?? 'N/A' }}</td>
                            <td>
                                @if ($user->hobbies)
                                    {{ implode(', ', $user->hobbies->pluck('name')->toArray()) }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if ($user->certificate)
                                    @foreach (json_decode($user->certificate) as $certificate)
                                        <a href="{{ asset('uploads/certificates/' . $certificate) }}" target="_blank">View</a><br>
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ json_decode($user->profile_info) ?? 'N/A' }}</td>
                            <td>
                                <a class="btn btn-warning btn-sm" href="{{route('matex.edit',$user->id)}}">Edit</a>
                                <form action="{{ route('matex.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-danger">Delete Selected</button>
        </div>
    </div>
</form>

<script>
function toggle(source) {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = source.checked;
    });
}
</script>

@endsection
