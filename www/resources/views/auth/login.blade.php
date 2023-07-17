<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.Head')
    <title>Asset Management</title>
</head>
<body class="d-flex flex-column min-vh-100">

    <div class="container" id="login-form">
    <div class="card">
        <div class="card-header">
            Login
        </div>
            <div class="card-body">
                <form action="{{ route('authenticate') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="mb-3 row">
                        <label for="username" class="col-md-4 col-form-label text-md-end text-start">Username</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}">
                                @if ($errors->has('username'))
                                    <span class="text-danger">{{ $errors->first('username') }}</span>
                                @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                        </div>
                    </div>
                    <div style="text-align: right">
                    <input type="submit" class="col-md-3 offset-md-5 btn btn-danger" value="Login">
                    </div>
                    </form>
                </div>
            </div>
        </div>        

</body>
</html>
