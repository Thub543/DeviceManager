<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.Head')
    <title>Asset Management</title>
    <script>
        function enableSubmit() {
            document.getElementById("submitBtn").disabled = false;
        }

        window.onload = function() {
            const inputs = document.querySelectorAll("input");
            inputs.forEach(input => {
                input.addEventListener("input", enableSubmit);
            });

            document.getElementById("submitBtn").disabled = true;
        };
    </script>
</head>
<body class="d-flex flex-column min-vh-100">

@include('layouts.Nav')

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif

<div class="container border border-5" id="edit-user">
    <h4 style="text-align: center">Edit User</h4>
    <form method="POST" id="userEditForm" name="userEditForm" action=" {{ route('users.update', $user->id) }}">
        @csrf
        @method('PATCH')
        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Name</label>
            <div class="col-sm-8">
                <input type="text" name="username" id="username" value="{{ $user->username }}" 
                class="form-control form-control-sm @error('username') is-invalid @enderror">
            </div>
        </div>
        @if ($errors->has('username'))
            <span class="text-danger">{{ $errors->first('username') }}</span>
        @endif

        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Password</label>
            <div class="col-sm-8">
                <input type="password" name="password_atm" id="password_atm" placeholder="old password"
                class="form-control form-control-sm @error('password_atm') is-invalid @enderror">
            </div>
        </div>
        @if ($errors->has('password_atm'))
            <span class="text-danger">{{ $errors->first('password_atm') }}</span>
        @endif

        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">New Password</label>
            <div class="col-sm-8">
                <input type="password" name="password" id="password" placeholder="new password"
                class="form-control form-control-sm @error('password') is-invalid @enderror">
            </div>
        </div>
        @if ($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
        @endif

        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Confirm new Password</label>
            <div class="col-sm-8">
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="confirm new password"
                class="form-control form-control-sm @error('password_confirmation') is-invalid @enderror">
            </div>
        </div>
        @if ($errors->has('password_confirmation'))
            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
        @endif

        <div class="searchform">
            <button class="btn btn-danger" type="submit" id="submitBtn">Edit User</button>
            <button class="btn btn-danger" type="reset">Reset Input</button>
                <a href="{{ Route('users.index') }}"> 
                    <button class="btn btn-danger" type="button">Cancel</button></a>
        </div>
    </form>
</div>



@include('layouts.Footer')
</body>
</html>
