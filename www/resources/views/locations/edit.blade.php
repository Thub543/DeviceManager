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
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container border border-5" id="admin-edit-location">
    <h4 style="text-align: center">Edit Locations</h4>
    <form method="POST" action=" {{ route('locations.update', $location->id) }}" >
        @csrf
        @method('PATCH')
        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Name</label>
            <div class="col-sm-8">
                <input type="text" name="location_name" value="{{ $location->location_name }}" class="form-control form-control-sm">
            </div>
        </div>
        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Initial</label>
            <div class="col-sm-8">
                <input type="text" name="location_initials" value="{{ $location->location_initials }}" class="form-control form-control-sm">
            </div>
        </div>
        <div class="searchform">
            <button class="btn btn-danger" type="submit" id="submitBtn">Edit Location</button>
            <button class="btn btn-danger" type="reset">Reset Input</button>
                <a href="{{ route('locations.index') }}">
                    <button class="btn btn-danger" type="button">Cancel</button></a>
        </div>
    </form>
</div>



@include('layouts.Footer')
</body>
</html>
