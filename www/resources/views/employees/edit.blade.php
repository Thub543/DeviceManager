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
            const inputs = document.querySelectorAll("input, select, textarea");
            inputs.forEach(input => {
                input.addEventListener("input", enableSubmit);
            });

            document.getElementById("submitBtn").disabled = true;
        };
    </script>
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

<div class="container border border-5" id="admin-edit-type">
    <h4 style="text-align: center">Edit Employee</h4>
    <form method="POST" action=" {{ route('employees.update', $emp->id) }}" >
        @csrf
        @method('PATCH')
        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Firstname</label>
            <div class="col-sm-8">
                <input type="text" name="firstname" value="{{ $emp->firstname }}" class="form-control form-control-sm">
            </div>
        </div>
        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Surname</label>
            <div class="col-sm-8">
                <input type="text" name="surname" value="{{ $emp->surname }}" class="form-control form-control-sm">
            </div>
        </div>
        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Pers. Num.</label>
            <div class="col-sm-8">
                <input type="text" name="personal_number" value="{{ $emp->personal_number}}" class="form-control form-control-sm">
            </div>
        </div>

        <div class="row mb-3">
            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Location</label>
            <div class="col-sm-8">
                <select class="form-select" name="location_id" id="location_id" arial-label="Default select example">
                    <option selected value="{{ $emp->location_id }}">{{ $emp->location->location_name  }}</option>
                    @foreach($locs as $loc)
                        <option value="{{ $loc->id }}">{{ $loc->location_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Updated at</label>
            <div class="col-sm-8">
                <input type="text" readonly disabled value="{{ $emp->updated_at }}" class="form-control form-control-sm">
            </div>
        </div>

        <div class="row mb-3">
            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Created at</label>
            <div class="col-sm-8">
                <input type="text" readonly disabled value="{{ $emp->created_at }}" class="form-control form-control-sm">
            </div>
        </div>
        <div class="searchform">
            <button type="submit" class="btn btn-danger" id="submitBtn">Edit Employee</button>
            <button type="reset" class="btn btn-danger">Reset Input</button>
            <a href="{{ route('employees.index') }}"> <button type="button" class="btn btn-danger">Cancel</button></a>
        </div>
    </form>
</div>



@include('layouts.Footer')
</body>
</html>
