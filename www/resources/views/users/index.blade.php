<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.Head')
    <title>Asset Management</title>
</head>
<body class="d-flex flex-column min-vh-100">
@include('layouts.Nav')

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="container border border-5" id="user-table">
<div class="searchform" id="form-spot">
    <a href=" {{ route('users.create') }}">
        <button type="button" class="btn btn-success" style="margin-top: 0.5rem">Add User</button>
    </a>
</div>
    <div class="table-responsive-xl">
        <table class="table table-fixed table-hover" id="table-main">
            <thead>
                <tr>
                    <th scope="col">Edit</th>
                    <th scope="col">Username</th>
                    <th scope="col">isAdmin</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            @foreach($users as $user)
                <tr>
                    <td id="td_nowrap">
                        <a href="{{route('users.edit', $user->id)}}">
                            <img src="{{ asset('images/edit_icon.png') }}" id="edit-icon">
                        </a></td>
                    <td id="td_nowrap"> {{ $user->username }} </td>
                    <td id="td_nowrap"> {{ $user->isAdmin }}</td>
                    <td id="td_nowrap">
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn" type="submit" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone!');">
                                <img src="{{ asset('images/delete_icon.png') }}" id="delete-icon">
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

@include('layouts.Footer')
</body>
</html>
