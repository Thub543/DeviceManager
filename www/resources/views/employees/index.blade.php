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

      @if(session('ImportError'))
            $(document).ready(function(){
                $('#importModal').modal('show');
            });
      @endif

    </script>
</head>
<body class="d-flex flex-column min-vh-100">

@include('layouts.Nav')

@if ($errors->has('value'))
    <p>{{ $errors->first('value') }}</p>
@endif
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

    <form class="searchform" style="margin-bottom: 0.5rem" action="{{ route('employees.search') }}" method="GET" id="form-spot" autocomplete="off">
        <input type="text" name="filter" placeholder="Search..." id="search-field">
        <button type="submit" class="btn btn-danger">Search</button>
        <a href="{{ route('employees.index') }}"><button type="button" class="btn btn-danger">clear search</button></a>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Add Employee
        </button>

        <button type="button" class="btn btn-success searchform" data-bs-toggle="modal" data-bs-target="#importModal">
            Import
        </button>
        <a class="btn btn-success" href="{{ route('employees.export') }}">Export</a>
    </form>



    <div class="table-responsive-xl" id="table-div">
        <table class="table table-hover table-striped table-bordered table-fixed" id="table-main">
            <thead>
                <tr>
                    <th scope="col">Edit</th>
                    <th scope="col">Firstname</th>
                    <th scope="col">Surname</th>
                    <th scope="col">Personal Number</th>
                    <th scope="col">Location</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>

            @foreach($emps as $emp)
                <tr>
                    <td id="td_nowrap"> <a href="{{ route('employees.edit', $emp->id )  }} ">
                            <img alt="" src="{{ asset('images/edit_icon.png') }}" id="edit-icon">
                    </a></td>
                    <td> {{ $emp->firstname }}</td>
                    <td> {{ $emp->surname }}</td>
                    <td> {{ $emp->personal_number }}</td>
                    <td> {{ $emp->location->location_name }}</td>
                    <td>
                    <form method="POST" action="{{ route('employees.destroy', $emp->id) }}">
                        @csrf
                        @method('DELETE')
                        <input type="image" class="edit-icon" onclick="confirm('{{ $emp->firstname }} {{ $emp->surname }} is going to be deleted. This delete is not recoverable!')" name="submit" src="{{ asset('images/delete_icon.png') }}" alt="Submit"/>

                    </form></td>
                </tr>
            @endforeach
        </table>
    </div>
<div id="page-selecter">{{ $emps->links() }} Showing {{($emps->currentpage()-1)*$emps->perpage()+1}} to {{$emps->currentpage()*$emps->perpage()}} of  {{$emps->total()}} entries</div>


<!-- add Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('employees.store')}}" id="employeeAddForm" autocomplete="off">
                    @csrf
                    <p> Firstname: <input type="text" name="firstname" value="{{ old('firstname') }}" class="form-control form-control-sm"></p>
                    @if ($errors->has('firstname'))
                        <span class="text-danger">{{ $errors->first('firstname') }}</span>
                    @endif
                    <p> Surname: <input type="text" name="surname" value="{{ old('surname') }}" class="form-control form-control-sm"> </p>
                    @if ($errors->has('surname'))
                        <span class="text-danger">{{ $errors->first('surname') }}</span>
                    @endif
                    <p> Personal Number: <input type="text" name="personal_number" value="{{ old('personal_number') }}" class="form-control form-control-sm"> </p>
                    @if ($errors->has('personal_number'))
                        <span class="text-danger">{{ $errors->first('personal_number') }}</span>
                    @endif

                    <p> Location:
                    <select class="form-select" name="location_id" id="location_id" arial-label="Default select example">
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}">{{ $loc->location_name}}</option>
                        @endforeach
                    </select>
                    </p>
                        @if ($errors->has('location_id'))
                            <span class="text-danger">{{ $errors->first('location_id') }}</span>
                       @endif
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-success" type="button" onclick="document.getElementById('employeeAddForm').submit()">Add</button>

            </div>
        </div>
    </div>
</div>

<!--import modal Modal -->
<div class="modal fade" id="importModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (session('ImportError'))
                    <span class="text-danger">{{ session('ImportError') }}</span>
                @endif
                <form action="{{ route('employees.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                    @csrf
                    <p><input type="file" name="file" id="customFile" size="10"> </p>
                    <p>Possible errors:</p>
                    <ul>
                        <li>First or Surname can not be empty.</li>
                        <li>First or Surname is only one char.</li>
                        <li>First or Surname is longer than 50 chars.</li>
                    </ul>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-success" type="button" onclick="document.getElementById('importForm').submit()">Import data</button>
            </div>
        </div>
    </div>
</div>



@include('layouts.Footer')
</body>

<script type="text/javascript">
    $(document).ready(function() {
        if(window.location.href.indexOf('#staticBackdrop') !== -1) {
            $('#staticBackdrop').modal('show');
        }
    });




</script>
</html>
