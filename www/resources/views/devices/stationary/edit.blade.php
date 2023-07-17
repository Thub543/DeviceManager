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
<body class="d-flex flex-column min-vh-100" id="edit-body">
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

<div class="container" id="edit-form-body">

    <div class="centered border border-5">
    <div class="wrapper">

    <form method="POST" action=" {{ route('stationary.update', $device->id) }}" id="edit-form">
    @csrf
    @method('PATCH')
    <h4 style="text-align: center"> Edit Device</h4>
    <div class="row">
    <div class="col-md-6" id="left-form"> <!-- Beginn des linken Containers -->
        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Inventory Number</label>
            <div class="col-sm-8">
                <input type="text" disabled readonly name="invnum" value="{{ $device->inventory_id }}" class="form-control form-control-sm">
            </div>
        </div>

        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">OrderID</label>
            <div class="col-sm-8">
                <input type="text" disabled readonly name="orderid" value="{{ $device->order->order_id }}" class="form-control form-control-sm">
            </div>
        </div>

        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Order Date</label>
            <div class="col-sm-8">
                <input type="text" disabled readonly name="orderdate" value="{{ $device->order->order_date->format('d.m.Y') }}" class="form-control form-control-sm">
            </div>
        </div>

        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Status</label>
            <div class="col-sm-8">
                <select class="form-select" name="status_id" id="ddStatus" arial-label="Default select example">
                    <option value="{{ $device->status_id }}">{{ $device->status->status_name }} </option>
                    @foreach($status as $state)
                        <option value="{{ $state->id }}">{{ $state->status_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Location</label>
            <div class="col-sm-8">
                <select class="form-select" name="location_id" id="ddLocation" arial-label="Default select example">
                    <option value="{{ $device->location_id }}">{{ $device->location->location_initials }} </option>
                    @foreach($location as $loc)
                        <option value="{{ $loc->id }}">{{ $loc->location_initials }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm"><a href="{{route('devicemodels.edit', $device->devicemodel->id)}}">Model</a></label>
            <div class="col-sm-8">
                <input type="text" disabled readonly name="devicemodel" value="{{ $device->devicemodel->model }}" class="form-control form-control-sm">
            </div>
        </div>

        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">OS</label>
            <div class="col-sm-8">
                <input type="text" disabled readonly name="os" value="{{ $device->devicemodel->os }}" class="form-control form-control-sm">
            </div>
        </div>
    </div> <!-- Ende des linken Container -->

    <div class="col-md-6" id="right-form"> <!-- Beginn des Rechten Containers -->
        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Type</label>
            <div class="col-sm-8">
                <input type="text" disabled readonly name="type" value="{{ $device->devicemodel->types->type_name }}" class="form-control form-control-sm">
            </div>
        </div>

        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">IMEI</label>
            <div class="col-sm-8">
                <input type="text" name="imei" value="{{ old('imei',$device->imei ) }}" maxlength="15" class="form-control form-control-sm">
            </div>
        </div>

        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Serial/Tag</label>
            <div class="col-sm-8">
                <input type="text" name="serial_tag" value="{{ old('serial_tag', $device->serial_tag) }}" class="form-control form-control-sm">
            </div>
        </div>

        <div class="row mb-3">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Warranty</label>
            <div class="col-sm-8">
                <input type="text" disabled readonly name="warranty" value="{{ $device->warranty->format('d.m.Y') }}" class="form-control form-control-sm">
            </div>
        </div>

        <div class="row mb-3">
            <label for="commentbox" class="col-sm-4 form-label">Comment</label>
            <div class="col-sm-8">
                <textarea class="form-control" style="resize: none" cols="50" rows="2" name="comment" maxlength="255" id="commentbox" rows="3">{{ $device->Comment }}</textarea>
            </div>
        </div>

    </div> <!-- Ende des rechten Containers -->
    </div> <!-- Ende der Row -->
    <div class="row">
        <div class="col-lg-6">
            <div class="row mb-3">
            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Created at</label>
                <div class="col-sm-8">
                    <input type="text" disabled readonly name="created_at" value="{{ $device->created_at }}" class="form-control form-control-sm">
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row mb-3">
            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Last updated at</label>
                <div class="col-sm-8">
                    <input type="text" disabled readonly name="updated_at" value="{{ $device->updated_at }}" class="form-control form-control-sm">
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6" id="left-button-form">
            <button type="submit" class="btn btn-danger" id="submitBtn">Edit Device</button>
            <button type="reset" class="btn btn-danger">Reset Input</button>
            <a href="{{ Route('devices.index') }}"> <button type="button" class="btn btn-danger">Cancel</button></a>
        </div>
        </form>
        <div class="col-lg-6">
            <form method="post" action="{{ route('devices.actions') }}" id="right-button-form">
                @csrf
                <input type="hidden" name="deviceid" value="{{ $device->id }}" >
                <button class="btn btn-danger" type="submit" name="action" value="stolen" onclick="return confirm('Are you sure you want to mark the device as stolen? The user will be removed, status is set to lost and location is set to IT');">Device stolen</button>
                <button class="btn btn-danger" type="submit" name="action" value="lost" onclick="return confirm('Are you sure you want to mark the device as lost? The user will be removed, status is set to lost and location is set to IT');">Device lost</button>
                <button class="btn btn-danger" type="submit" name="action" value="damaged" onclick="return confirm('Are you sure you want to mark the device as damaged? The user will be removed, status is set to lost and location is set to IT');">Device damaged</button>
                <button class="btn btn-danger" type="submit" name="action" value="deleted" onclick="return confirm('Are you sure you want to mark the device as deleted? The user will be removed, status is set to delete and location is set to IT');">Device delete</button>
            </form>
        </div>
    </div>

    </div>
    </div>
@include('layouts.Footer')
</body>
</html>
