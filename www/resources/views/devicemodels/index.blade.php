<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.Head')
    <title>Asset Management</title>

    <script>
        @if(session('errors'))
            $(document).ready(function(){
            $('#staticBackdrop').modal('show');
            });
        @endif
    </script>

</head>
<body class="d-flex flex-column min-vh-100">
<style>
    @media(max-width: 600px){
        #search-field{
            width: 100px;
        }
    }
    </style>
@include('layouts.Nav')
<form class="searchform" action="{{ route('devicemodels.devicemodelSearch') }}" method="GET" id="form-spot" style="margin-bottom: 0.5rem" autocomplete="off">
    <input type="text" name="q" placeholder="Search..." id="search-field">
    <select multiple="multiple" name="types[]" id="types" style="widht: 100%;max-width: 200px">
        @foreach($types as $type)
            <option value="{{ $type->id }}"> {{ $type->type_name }}</option>
        @endforeach
    </select>
    <button class="btn btn-danger" type="submit">Search</button>
    <a href="{{ route('devicemodels.index') }}"><button type="button" class="btn btn-danger">clear search</button></a>

    <button type="button" id="add_dm" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Add Devicemodel
    </button>
</form>
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="table-responsive-xl" id="table-div">
    <table class="table table-hover table-striped table-bordered table-fixed" id="table-main">
        <thead>
            <tr>
                <th scope="col">Edit</th>
                <th scope="col">Model</th>
                <th scope="col">Vendor</th>
                <th scope="col">OS</th>
                <th scope="col">Type</th>
                <th scope="col">created at</th>
                <th scope="col">Updated at</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>

        @foreach($devicemodels as $devicemodel)
            <tr>
                <td id="td_nowrap"> <a href="{{ route('devicemodels.edit', $devicemodel->id )  }} ">
                    <img alt="" src="{{ asset('images/edit_icon.png') }}" class="edit-icon">
                </a></td>
                <td id="td_nowrap"> {{ $devicemodel->model }} </td>
                <td id="td_nowrap"> {{ $devicemodel->vendor }}</td>
                <td id="td_nowrap"> {{ $devicemodel->os }} </td>
                <td id="td_nowrap"> {{ $devicemodel->types->type_name }} </td>
                <td id="td_nowrap"> {{ $devicemodel->created_at }} </td>
                <td id="td_nowrap"> {{ $devicemodel->updated_at }}</td>
                <td id="td_nowrap">
                <form method="POST" action="{{ route('devicemodels.destroy', $devicemodel->id) }}">
                    @csrf
                    @method('DELETE')
                    <input type="image" class="edit-icon" onclick="confirm('{{ $devicemodel->model }} is going to be deleted. This delete is not recoverable!')" name="submit" src="{{ asset('images/delete_icon.png') }}" alt="Submit"/>

                </form>
              </td>
            </tr>
        @endforeach
    </table>
</div>
<div id="page-selecter">{{ $devicemodels->links() }} Showing {{($devicemodels->currentpage()-1)*$devicemodels->perpage()+1}} to {{$devicemodels->currentpage()*$devicemodels->perpage()}} of  {{$devicemodels->total()}} entries</div>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Devicemodel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('devicemodels.store')}}" id="dmAddForm">
                    @csrf
                    <p> Model: <input type="text" name="model" value="{{ old('model') }}" class="form-control form-control-sm"></p>
                    @if ($errors->has('model'))
                        <span class="text-danger">{{ $errors->first('model') }}</span>
                    @endif
                    <p> Vendor: <input type="text" name="vendor" value="{{ old('vendor') }}" class="form-control form-control-sm"> </p>
                    @if ($errors->has('vendor'))
                        <span class="text-danger">{{ $errors->first('vendor') }}</span>
                    @endif
                    <p> OS: <input type="text" name="os" value="{{ old('os') }}" class="form-control form-control-sm"> </p>
                    @if ($errors->has('os'))
                        <span class="text-danger">{{ $errors->first('os') }}</span>
                    @endif
                    <p> Type:
                    <select class="form-select" name="type_id" id="type_id" arial-label="Default select example">
                        <option hidden value="default">Select a Type..</option>
                        @foreach($types as $type)
                            @if (old('type_id') == $type->id)
                                <option value="{{ $type->id }}" selected>{{ $type->type_name }} {{ $type->isStationary ? '[Stationary]': '' }}</option>
                            @else
                                <option value="{{ $type->id }}">{{ $type->type_name }} {{ $type->isStationary ? '[Stationary]': '' }}</option>
                            @endif
                        @endforeach
                    </select></p>
                    @if ($errors->has('type_id'))
                        <span class="text-danger">{{ $errors->first('type_id') }}</span>
                    @endif
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-success" type="button" onclick="document.getElementById('dmAddForm').submit()">Add</button>

            </div>
        </div>
    </div>
</div>



@include('layouts.Footer')
</body>
    <script>
        $('#types').select2({
            placeholder: 'Choose a type',
                allowClear: true
        });
    </script>
</html>
