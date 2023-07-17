<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.Head')
    <title>Asset Management</title>

</head>
<body class="d-flex flex-column min-vh-100">
@include('layouts.Nav')

<form class="searchform" action="{{ route('devices.stationarySearch') }}" method="GET" id="form-spot" style="margin-bottom: 0.5rem">
    <input type="text" name="q" placeholder="Search..." id="search-field">
        <button type="submit" class="btn btn-danger">Search</button>
        <a href="{{ route('stationaryDevices') }}">
            <button class="btn btn-danger" type="button">clear search</button></a>
</form>

<div class="table-responsive-xl" id="table-div">
<table class="table table-hover table-striped table-bordered table-fixed">
    <thead>
    <tr>
        <th id="th_nostyle">Edit</th>
        <th scope="col" id="th_nostyle"> @sortablelink('inventory_id','ID')
            <img src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
        </th>
        <th scope="col" id="th_nostyle">Status</th>
        <th th scope="col" id="th_nostyle"> @sortablelink('location.location_initials','Location')
        <img src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
        </th>
        <th scope="col" id="th_nostyle"> @sortablelink('devicemodel.model','Model')
        <img src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
        </th>
        <th scope="col" id="th_nostyle"> @sortablelink('devicemodel.vendor','Vendor')
        <img src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
        </th>
        <th id="th_nostyle"> OrderID</th>
        <th scope="col" id="th_nostyle"> @sortablelink('order.order_date','Order Date')
        <img src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
        </th>
        <th id="th_nostyle"> Serial/Tag</th>
        <th id="th_nostyle"> Imei</th>
        <th id="th_nostyle"> Comment</th>
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
            <td id="td_nowrap"> <a href="{{ route('stationary.edit', $device->id )  }} "><img src="{{ asset('images/edit_icon.png') }}" id="edit-icon"></a></td>
            <td id="td_nowrap"> {{ $device->inventory_id}} </td>
            <td id="td_nowrap"> {{ $device->status->status_name}} </td>
            <td id="td_nowrap"> {{ $device->location->location_initials }} </td>
            <td id="td_nowrap"> {{ $device->devicemodel->model}}</td>
            <td id="td_nowrap"> {{ $device->devicemodel->vendor}}</td>
            <td id="td_nowrap">
                <a href="{{ route('orders.edit', $device->order->id) }}">{{ $device->order->order_id }}
                    <img src="{{ asset('images/order_icon.png') }}" id="order-icon">
                </a>
            </td>
            <td id="td_nowrap"> {{ $device->order->order_date->format('d.m.Y') }} </td>
            <td id="td_nowrap"> {{ $device->serial_tag}} </td>
            <td id="td_nowrap"> {{ $device->imei}} </td>
            <td id="td_nowrap"> {{ Str::limit($device->comment, 30) }} </td>
        </tr>
    @endforeach
    @endif
    </tbody>
</table>
    {!! $devices->appends(\Request::except('page'))->render() !!} Showing {{($devices->currentpage()-1)*$devices->perpage()+1}} to {{$devices->currentpage()*$devices->perpage()}} of  {{$devices->total()}} entries

    </div>




@include('layouts.Footer')
</body>
</html>
