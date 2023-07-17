<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.Head')
    <title>Asset Management</title>
</head>
<body class="d-flex flex-column min-vh-100">
@include('layouts.Nav')
<br>
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
<form action="{{ route('manageRequestOffboarding') }}" method="POST">
    <div id="return-buttons" style="margin-bottom: 0.5rem;">
        <button class="btn btn-danger" type="submit" name="action" value="confirm">Confirm</button>
        <a href="{{ route('activeHandovers') }}" ><button class="btn btn-danger" type="button">Cancel</button></a>
        <button class="btn btn-danger" type="submit" name="action" value="pdf" formtarget="_blank">Generate PDF</button>
    </div>
    @csrf
    <div class="table-responsive-xl" id="table-div">
    <table class="table table-hover table-striped table-bordered table-fixed">
    <thead>
        <tr>
            <th scope="col">Firstname</th>
            <th scope="col">Lastname</th>
            <th scope="col">Handover Date</th>
            <th scope="col">Inventory Number</th>
            <th scope="col">Model</th>
            <th scope="col">Choose a status</th>
        </tr>
    </thead>
    @foreach($handovers as $handover)
        <tr>
            <input type="hidden" name="handoversid[]" value="{{ $handover->id }}">
            <td id="td_nowrap">{{ $handover->employee->firstname }}</td>
            <td id="td_nowrap">{{ $handover->employee->surname }}</td>
            <td id="td_nowrap"> {{ $handover->handover_date->format('d.m.Y') }} </td>
            <td id="td_nowrap"><a href=" {{ route('devices.edit', $handover->device_id ) }}" style="text-decoration: none; color: black;">{{$handover->device->inventory_id }}
                <img src="{{ asset('images/order_icon.png') }}" id="order-icon">
            </a></td>
            <td id="td_nowrap">{{ $handover->device->devicemodel->model }}</td>
            <td id="td_nowrap">
                <select class="form-select" name="ddStatus[]">
                    @foreach($availableStates as $avStatus)
                        <option value="{{ $avStatus->id }}"> {{ $avStatus->status_name }} </option>
                    @endforeach
                </select></td>
        </tr>
  @endforeach
    </table>
    </div>
</form>



@include('layouts.Footer')
</body>
</html>
