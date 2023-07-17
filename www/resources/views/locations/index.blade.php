<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.Head')

    <title>Asset Management</title>

    <script>

        //to open modal if there are errors
        @if(session('errors'))
        $(document).ready(function(){
            $('#staticBackdrop').modal('show');
        });
        @endif
    </script>
</head>
<body class="d-flex flex-column min-vh-100">

@include('layouts.Nav')

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif


    <div class="searchform" style="margin-bottom: 0.5rem" id="form-spot">
        <button type="button" class="btn btn-success" style="margin-top: 0.5rem" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Add Location
        </button>
    </div>

<div class="table-responsive-xl" id="table-div">
    <table class="table table-hover table-striped table-bordered table-fixed" id="table-main">
        <thead>
            <tr>
                <th scope="col">Edit</th>
                <th scope="col">Name</th>
                <th scope="col">Initials</th>
                <th scope="col">Created at</th>
                <th scope="col">Updated at</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>

        @foreach($locations as $location)
            <tr>
                <td id="td_nowrap">
                    <a href="{{ route('locations.edit', $location->id )  }} ">
                        <img src="{{ asset('images/edit_icon.png') }}" id="edit-icon">
                    </a></td>
                <td id="td_nowrap"> {{ $location->location_name }} </td>
                <td id="td_nowrap"> {{ $location->location_initials }}</td>
                <td id="td_nowrap"> {{ $location->created_at }} </td>
                <td id="td_nowrap"> {{ $location->updated_at }}</td>
                <td id="td_nowrap">
                    <form method="POST" action="{{ route('locations.destroy', $location->id) }}">
                        @csrf
                        @method('DELETE')
                        <input type="image" onclick="confirm('{{ $location->location_name }} is going to be deleted. This delete is not recoverable!')" class="edit-icon" name="submit" src="{{ asset('images/delete_icon.png') }}" alt="Submit"/>

                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('locations.store') }}" id="locationAddForm">
                    @csrf
                    <p> Name: <input type="text" name="location_name" value="{{ old('location_name') }}" class="form-control form-control-sm"></p>
                    @if ($errors->has('location_name'))
                        <span class="text-danger">{{ $errors->first('location_name') }}</span>
                    @endif
                    <p> Initials: <input type="text" name="location_initials" value="{{ old('location_initials') }}" class="form-control form-control-sm"> </p>
                    @if ($errors->has('location_initials'))
                        <span class="text-danger">{{ $errors->first('location_initials') }}</span>
                    @endif
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-success" type="button" onclick="document.getElementById('locationAddForm').submit()">Add</button>

            </div>
        </div>
    </div>
</div>

@include('layouts.Footer')
</body>
</html>
