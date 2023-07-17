<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.Head')
    <title>Asset Management</title>

    <script>
        // open modal if there are errors
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
            Add Type
        </button>
    </div>

<div class="table-responsive-xl" id="table-div">
    <table class="table table-hover table-striped table-bordered table-fixed" id="table-main">
        <thead>
            <tr>
                <th scope="col">Edit</th>
                <th scope="col">Name</th>
                <th scope="col">Initials</th>
                <th scope="col">isStationary</th>
                <th scope="col">Created at</th>
                <th scope="col">Updated at</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>

        @foreach($types as $type)
            <tr>
                <td id="td_nowrap">
                    <a href="{{ route('types.edit', $type->id )  }} ">
                        <img alt="" src="{{ asset('images/edit_icon.png') }}" id="edit-icon">
                    </a></td>
                <td id="td_nowrap"> {{ $type->type_name }} </td>
                <td id="td_nowrap"> {{ $type->type_initials }}</td>
                <td id="td_nowrap"> {{ $type->isStationary ? 'True':'False' }}</td>
                <td id="td_nowrap"> {{ $type->created_at }} </td>
                <td id="td_nowrap"> {{ $type->updated_at }}</td>
                <td>
                    <form method="POST" action="{{ route('types.destroy', $type->id) }}">
                        @csrf
                        @method('DELETE')
                        <input type="image" class="edit-icon" onclick="confirm('{{ $type->type_name }} is going to be deleted. This delete is not recoverable!')" name="submit" src="{{ asset('images/delete_icon.png') }}" alt="Submit"/>

                    </form></td>
            </tr>
        @endforeach
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('types.store')}}" id="typeAddForm">
                    @csrf
                    <p> Name: <input type="text" name="type_name" value="{{ old('type_name') }}" class="form-control form-control-sm"></p>
                    @if ($errors->has('type_name'))
                        <span class="text-danger">{{ $errors->first('type_name') }}</span>
                    @endif
                    <p> Initals: <input type="text" name="type_initials" value="{{ old('type_initials') }}" class="form-control form-control-sm"> </p>
                    @if ($errors->has('type_initials'))
                        <span class="text-danger">{{ $errors->first('type_initials') }}</span>
                    @endif
                    <p> isStationary: <input type="checkbox" name="isStationary" value="1" {{ old('isStationary') == 0 ? 1 : '' }} > </p>
                    @if ($errors->has('isStationary'))
                        <span class="text-danger">{{ $errors->first('isStationary') }}</span>
                    @endif
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-success" type="button" onclick="document.getElementById('typeAddForm').submit()">Add</button>

            </div>
        </div>
    </div>
</div>

@include('layouts.Footer')
</body>
</html>
