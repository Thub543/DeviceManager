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
            const inputs = document.querySelectorAll("input, select");
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

<div class="container border border-5" id="admin-edit-device">
    <h4 style="text-align: center">Edit Devicemodel</h4>
    <form method="POST" action=" {{ route('devicemodels.update', $devicemodel->id) }}" >
        @csrf
        @method('PATCH')
        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Model</label>
            <div class="col-sm-8">
                <input type="text" name="model" value="{{ $devicemodel->model }}" class="form-control form-control-sm">
            </div>
        </div>
        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Vendor</label>
            <div class="col-sm-8">
                <input type="text" name="vendor" value="{{ $devicemodel->vendor }}" class="form-control form-control-sm">
            </div>
        </div>
        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">OS</label>
            <div class="col-sm-8">
                <input type="text" name="os" value="{{ $devicemodel->os }}" class="form-control form-control-sm">
            </div>
        </div>
        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Type</label>
            <div class="col-sm-8">
                <select class="form-select" name="type_id" id="type_id" arial-label="Default select example">
                    <option selected value="{{ $devicemodel->type_id }}">{{ $devicemodel->types->type_name  }}</option>
                    @foreach($types as $typ)
                        <option value="{{ $typ->id }}">{{ $typ->type_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="searchform">
            <button class="btn btn-danger" type="submit" id="submitBtn">Edit Devicemodel</button>
            <button class="btn btn-danger" type="reset">Reset Input</button>
                <a href="{{ route('devicemodels.index') }}">
                    <button class="btn btn-danger" type="button">Cancel</button>
                </a>
        </div>
    </form>
</div>


@include('layouts.Footer')
</body>
</html>
