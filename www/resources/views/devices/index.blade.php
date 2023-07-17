<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.Head')
    <title>Asset Management</title>
</head>

<body class="d-flex flex-column min-vh-100">´

@include('layouts.Nav')
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif


<form class="searchform" style="margin-bottom: 0.5rem" action="{{ route('devices.overviewSearch') }}" method="GET" id="form-spot" autocomplete="off">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search..." id="search-field" >
    <select multiple="multiple" name="status[]" id="status" style="max-width: 300px">
                @foreach($status as $state)
                    @php
                        $selected = in_array($state->id, request()->input('status', []));
                    @endphp
                    @if($selected)
                        <option value="{{ $state->id }}" selected>{{ $state->status_name }}</option>
                    @else
                        <option value="{{ $state->id }}">{{ $state->status_name }}</option>
                    @endif
                @endforeach
        </select>

    <button type="submit" class="btn btn-danger">Search</button>
        <a href="{{ route('devices.index') }}"><button type="button" class="btn btn-danger">Clear search</button></a>
    @if($isFilter)
        <button type="submit" name="action" value="filtered" class="btn btn-success">Export Filtered</button>
    @else
        <a class="btn btn-success" href="{{ route('devices.export') }}">Export all</a>
    @endif
</form>

<div class="table-responsive" id="table-div">
<table class="table table-hover table-striped table-bordered table-fixed" id="table-main">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Edit</th>
        <th scope="col" id="th_nostyle"> @sortablelink('inventory_id','ID')
        <img alt="" src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
        </th>
        <th scope="col" id="th_nostyle"> @sortablelink('status.status_name','Status')
        <img alt="" src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
        </th>
        <th scope="col" id="th_nostyle"> @sortablelink('location.location_Initials','Location')
        <img alt="" src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
        </th>
        <th scope="col" id="th_nostyle"> @sortablelink('devicemodel.model','model')
        <img alt="" src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
        </th>
        <th scope="col" id="th_nostyle"> @sortablelink('devicemodel.vendor','vendor')
        <img alt="" src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
        </th>
        <th scope="col"> Current Employee</th>
        <th scope="col"> Last Employee</th>
        <th scope="col"> OrderID </th>
        <th scope="col"> IMEI </th>
        <th scope="col"> Comment</th>
    </tr>
    </thead>
    <tbody>
    @if($devices->count() == 0)
        <tr>
            <td colspan="13" style="text-align: center">No devices found</td>
        </tr>
    @else
    @foreach($devices as $device)
        <tr>
            <td> <a href="{{ route('devices.edit', $device->id) }} ">
                    <img alt="" src="{{ asset('images/edit_icon.png') }}" id="edit-icon">
                </a>
            </td>
            <td id="td_nowrap">{{ $device->inventory_id}}</td>
            <td id="td_nowrap"> {{ $device->deviceState }} </td>
            <td id="td_nowrap"> {{ $device->current_location_initials }} </td>
            <td id="td_nowrap"> {{ $device->model}}</td>
            <td id="td_nowrap"> {{ $device->vendor}}</td>
            <td id="td_nowrap">
                <a href ="{{ route('handovers.allHandoversSearch')}}?q={{$device->current_firstname ?? "" }} {{$device->current_surname ?? ""}}" style="text-decoration: none; color: black;">
                    {{ $device->current_firstname ?? ""}} {{ $device->current_surname ?? "" }}
                </a>
            </td>
            <td id="td_nowrap">
                <a href ="{{ route('handovers.allHandoversSearch')}}?q={{$device->last_firstname ?? "" }} {{$device->last_surname ?? ""}}" style="text-decoration: none; color: black;">
                    {{ $device->last_firstname ?? ""}} {{ $device->last_surname ?? "" }}
                </a>
            </td>
            <td id="td_nowrap">
                <a href="{{ route('orders.edit', ['oid' => $device->oid]) }}" style="text-decoration: none; color: black;">
                    {{ $device->deviceOrderId }}
                    <img alt="" src="{{ asset('images/order_icon.png') }}" id="order-icon">
                </a>
            </td>
            <td id="td_nowrap"> {{ $device->imei}} </td>
            <td id="td_nowrap"> {{ Str::limit($device->comment, 15) }} </td>
        </tr>
    @endforeach
    </tbody>
    @endif
</table>
</div>
<div id="page-selecter">{{ $devices->links() }} Showing {{($devices->currentpage()-1)*$devices->perpage()+1}} to {{$devices->currentpage()*$devices->perpage()}} of  {{$devices->total()}} entries</div>
@include('layouts.Footer')
</body>
    <script>
        $('#status').select2({
            placeholder: 'Choose status',
            allowClear: true
        });
    </script>
</html>
