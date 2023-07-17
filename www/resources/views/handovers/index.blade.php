<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.Head')
    <title>Asset Management</title>
</head>
<body class="d-flex flex-column min-vh-100">
@include('layouts.Nav')

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form class="searchform" action="{{ route('handovers.allHandoversSearch') }}" method="GET" id="form-spot" style="margin-bottom: 0.5rem" autocomplete="off">
    <input type="text" name="q" placeholder="Search..." id="search-field">
        <button class="btn btn-danger" type="submit">Search</button>
        <div>
            <a href="{{ route('handovers.index') }}">
                <button class="btn btn-danger" type="button">clear search</button></a>
        </div>
    </form>

<div class="table-responsive-xl" id="table-div">
    <table class="table table-hover table-striped table-bordered table-fixed" id="table-main">
        <thead>
            <tr>
                <th scope="col" id="th_nostyle"> @sortablelink('employee.firstname','firstname')
                    <img alt="" src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
                </th>
                <th scope="col" id="th_nostyle"> @sortablelink('employee.surname','surname')
                    <img alt="" src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
                </th>
                <th scope="col" id="th_nostyle"> @sortablelink('handover_date','Handover Date')
                    <img alt="" src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
                </th>
                <th scope="col" id="th_nostyle"> @sortablelink('return_date','Return Date')
                    <img alt="" src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
                </th>
                <th scope="col" id="th_nostyle"> @sortablelink('device.inventory_id','Inventory Number')
                    <img alt="" src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
                </th>
                <th scope="col">Model</th>
                <th scope="col">Last action by</th>
            </tr>
        </thead>
        @foreach($handovers as $handover)
            <tr>
                <td id="td_nowrap"> {{ $handover->firstname }} </td>
                <td id="td_nowrap"> {{ $handover->surname }}</td>
                <td id="td_nowrap"> {{ $handover->handover_date->format('d.m.Y') }} </td>
                <td id="td_nowrap"> {{ $handover->return_date == null ? 'is used' : date('d.m.Y', strtotime($handover->return_date)) }}</td>
                <td id="td_nowrap"> <a href=" {{ route('devices.edit', $handover->device_id ) }}" style="text-decoration: none; color: black;">{{$handover->device->inventory_id }}
                    <img alt="" src="{{ asset('images/order_icon.png') }}" id="order-icon">
                </a></td>
                <td id="td_nowrap"> {{ $handover->model }}</td>
                <td id="td_nowrap"> {{ $handover->user->username ?? $handover->username}} </td>
            </tr>
            @endforeach
    </table>
</div>

<div id="page-selecter">
    {!! $handovers->appends(\Request::except('page'))->render() !!} Showing {{($handovers->currentpage()-1)*$handovers->perpage()+1}} to {{$handovers->currentpage()*$handovers->perpage() }} of  {{$handovers->total()}} entries

</div>

@include('layouts.Footer')
</body>
</html>
