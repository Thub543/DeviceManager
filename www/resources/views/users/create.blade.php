<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.Head')
    <title>Asset Management</title>

</head>
<body class="d-flex flex-column min-vh-100">

@include('layouts.Nav')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container border border-5" id="create-user">
    <h4 style="text-align: center">Create User</h4>
    <form method="POST" action=" {{ route('users.store') }}" autocomplete="off">
        @csrf
        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Username</label>
            <div class="col-sm-8">
                <input type="text" name="username" value="{{ old('username') }}" class="form-control form-control-sm">
            </div>
        </div>
        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Password</label>
            <div class="col-sm-8">
                <input type="password" name="password" class="form-control form-control-sm">
            </div>
        </div>
        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Password</label>
            <div class="col-sm-8">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control form-control-sm">
            </div>
        </div>
        <div class="row mb-3">
            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Admin</label>
                <div class="col-sm-8" style="text-align: left">
                    <input class="form-check-input" type="checkbox" name="isAdmin" value="true" id="flexCheckDefault">
                </div>
        </div>
        <div class="searchform">
            <button class="btn btn-danger" type="submit">Create User</button>
            <button class="btn btn-danger" type="reset">Reset Input</button>
                <a href="{{ Route('users.index') }}"> 
                    <button class="btn btn-danger" type="button">Cancel</button></a>
        </div>
    </form>

</div>



@include('layouts.Footer')
</body>
</html>
