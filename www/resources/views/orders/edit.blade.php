<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.Head')
    <title>Asset Management</title>

    <script>
        function toggle(source) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] !== source && !checkboxes[i].disabled)
                    checkboxes[i].checked = source.checked;
            }
        }
    </script>
</head>
<body class="d-flex flex-column min-vh-100">

@include('layouts.Nav')

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

    <form method="post" action="{{ route('orders.MarkArrived') }}">
    @csrf
    <div class="searchform" id="form-spot">
        <h4> Order {{ $devices[0]->order->order_id }}</h4>
        <h6> From {{ $devices[0]->order->order_date->format('d.m.Y') }}</h6>
        <div class="row">
            <label for="colFormLabelSm" class="col-sm-8 col-form-label col-form-label-sm">Select all</label>
                <div class="col-sm-4">
                    <input class="form-check-input" type="checkbox" onclick="toggle(this);" name="cbAll" id="center_cb">
                </div>
        </div>
        <button class="btn btn-danger" type="submit">Mark as arrived</button>
    </div>
    <div class="table-responsive-xl" id="table-div">
        <table class="table table-hover table-striped table-bordered table-fixed" id="table-main">
            <thead>
                <tr>
                    <th scope="col">select</th>
                    <th scope="col">Inventory ID </th>
                    <th scope="col">Model</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            @foreach($devices as $device)
                <tr>
                    <td id="td_nowrap"> <input type="checkbox" @if($device->status->status_name != 'ordered') disabled @endif name="cbDevices[]" value="{{ $device->id }}"></td>
                    <td id="td_nowrap"><a href="{{route('devices.edit', $device->id)}}"> {{ $device->inventory_id }}</a></td>
                    <td id="td_nowrap">{{ $device->devicemodel->model }}</td>
                    <td id="td_nowrap">{{ $device->status->status_name }}</td>
                </tr>
            @endforeach
        </table>
    </div>
    </form>
@include('layouts.Footer')
</body>
</html>
















