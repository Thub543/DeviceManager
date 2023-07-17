<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.Head')
    <title>Asset Management</title>
</head>
<body class="d-flex flex-column min-vh-100">
@include('layouts.Nav')


@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form class="searchform" style="margin-bottom: 0.5rem" action="{{ route('orders.search') }}" method="GET" id="form-spot">
    <input type="text" name="filter" placeholder="Search..." id="search-field">
    <button type="submit" class="btn btn-danger">Search</button>
    <a href="{{ route('orders.index') }}"><button type="button"class="btn btn-danger">clear search</button></a>
</form>

<div class="table-responsive-xl" id="table-div">
    <table class="table table-hover table-striped table-bordered table-fixed" id="table-main">
        <thead>
        <tr>
            <th id="th_nostyle">Edit</th>
            <th id="th_nostyle">Order ID</th>
            <th id="th_nostyle">Order Date</th>
            <th id="th_nostyle">Devices in the order</th>
            <th id="th_nostyle">Devices delivered</th>
        </tr>
        </thead>
        <tbody>
        @if($orders->count() == 0)
            <tr>
                <td colspan="13" style="text-align: center">No orders found</td>
            </tr>
        @else
        @foreach($orders as $order)
            <tr>
                <td id="td_nowrap"><a href="{{ route('orders.edit', $order->id) }}"><img alt="" src="{{ asset('images/edit_icon.png') }}" id="edit-icon"></a></td>
                <td id="td_nowrap">{{ $order->order_id }}</td>
                <td id="td_nowrap">{{ $order->order_date->format('d.m.Y') }}</td>
                <td id="td_nowrap">{{ $order->devices_count }}</td>
                <td id="td_nowrap">{{ $order->notOrderDevices }}</td>
            </tr>
        @endforeach
        @endif
        </tbody>
    </table>
    <div id="page-selecter">{{ $orders->links() }}</div>
</div>
@include('layouts.Footer')
</body>
</html>
















