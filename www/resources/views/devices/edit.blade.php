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

    <form method="POST" action=" {{ route('devices.update', $device->id) }}" id="edit-form">
    <h4 style="text-align: center"> Edit Device</h4>
        @csrf
        @method('PATCH')
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
                <input type="text" disabled readonly name="status" value="{{ $device->status->status_name }}" class="form-control form-control-sm">
            </div>
        </div>

        <div class="row mb-3">
            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Location
                @if($device->currentEmployee != null)
                <span class="badge bg-info" onclick="confirm('This location changes the location of the employee.')">Info</span>
                @endif
            </label>
            <div class="col-sm-8">
                @if($device->currentEmployee == null)
                    <input type="text" disabled readonly name="loc" value="IT" class="form-control form-control-sm">
                @else
                    <select class="form-select" name="location_id" id="ddLocation" arial-label="Default select example">
                        <option value="{{ $device->currentEmployee->location_id }}">{{ $device->currentEmployee->location->location_initials }} </option>
                        @foreach($location as $loc)
                            <option value="{{ $loc->id }}">{{ $loc->location_initials }}</option>
                        @endforeach
                    </select>
                @endif
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

        <div class="row mb-3">
            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Last Action by </label>
            <div class="col-sm-8">
                <input type="text" disabled readonly name="username" value="{{ $device->users->username }}" class="form-control form-control-sm">
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
            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Current Employee</label>
            <div class="col-sm-8">
                <input type="text" disabled readonly name="currentUser" value="{{ $device->currentEmployee->firstname ?? ""}} {{ $device->currentEmployee->surname ?? "" }}" class="form-control form-control-sm">
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
                <input type="date" name="warranty" value="{{ $device->warranty->format('Y-m-d') }}" class="form-control form-control-sm">
            </div>
        </div>
        <div class="row mb-3">
            <label for="commentbox" class="col-sm-4 form-label">Comment</label>
            <div class="col-sm-8">
                <textarea class="form-control" style="resize: none" cols="50" rows="2" name="comment" maxlength="255" id="commentbox" rows="3">{{ $device->comment }}</textarea>
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
                <input type="hidden" name="deviceid" value="{{ $device->id }}">
                @if($device->status->status_name == "assigned" || $device->status->status_name == "in Store")
                    <button class="btn btn-danger" type="submit" name="action" value="deleted" onclick="return confirm('Are you sure you want to mark the device as deleted? The user will be removed, status is set to delete and location is set to IT.');">Device delete</button>
                    <button class="btn btn-danger" type="submit" name="action" value="stolen" onclick="return confirm('Are you sure you want to mark the device as stolen? The user will be removed, status is set to lost and location is set to IT.');">Device stolen</button>
                    <button class="btn btn-danger" type="submit" name="action" value="lost" onclick="return confirm('Are you sure you want to mark the device as lost? The user will be removed, status is set to lost and location is set to IT.');">Device lost</button>
                    <button class="btn btn-danger" type="submit" name="action" value="damaged" onclick="return confirm('Are you sure you want to mark the device as damaged? The user will be removed, status is set to lost and location is set to IT.');">Device damaged</button>
                    @if($device->status->status_name != "in Store")
                        <button class="btn btn-danger" type="submit" name="action" value="in Store" onclick="return confirm('Are you sure you want to return the device without PDF generation? The user will be removed, status is set to in Store and location is set to IT.');">Quick return</button>
                    @endif
                @elseif($device->status->status_name == "ordered")
                    <button class="btn btn-danger" type="submit" name="action" value="in Store" onclick="return confirm('This action will recover this device.');">Mark as in Store</button>
                @elseif($device->status->status_name == "offboarding")

                @else
                    <button class="btn btn-danger" type="submit" name="action" value="recovered" onclick="return confirm('This action will recover this device.');">Recover</button>
                @endif
            </form>
        </div>
    </div>

    <h4 style="border-top: 3px solid #DEE2E6; margin-top: 10px;"> History</h4>
    @if(count($lastusers) == 0)
        <p> No history available</p>
    @else
    <div class="table-responsive-xl">
    <table class="table">
        <thead>
            <tr>
                <th scope="col"> Firstname </th>
                <th scope="col"> Surname </th>
                <th scope="col"> From</th>
                <th scope="col"> To</th>
            </tr>
        </thead>
        @foreach($lastusers as $lu)
            <tr>
                <td id="td_nowrap">{{ $lu->firstname }}</td>
                <td id="td_nowrap">{{ $lu->surname }}</td>
                @if(isset($lu->handover_date))
                <td id="td_nowrap">{{ $lu->handover_date->format('d-m-Y') }}</td>
                <td id="td_nowrap">{{ $lu->return_date->format('d-m-Y') }}</td>
                @endif
            </tr>
        @endforeach
    </table>
    </div>
    @endif

    </div>
    </div>
@include('layouts.Footer')
</body>
</html>
