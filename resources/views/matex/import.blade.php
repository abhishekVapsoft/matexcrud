@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Import Users</h2>
    

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('matex.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file">Choose Excel File:</label>
                    <input type="file" name="file" class="form-control-file" required>
                    <small class="form-text text-muted">Please upload a valid Excel file.</small>
                </div>
                <button type="submit" class="btn btn-success">Import Users</button>
                <a class="btn btn-primary" href="{{ route('matex.index') }}"> Back</a>
            </form>
        </div>
    </div>
</div>
@endsection
