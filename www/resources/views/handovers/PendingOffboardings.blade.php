<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.Head')
    <title>Asset Management</title>
</head>
<body class="d-flex flex-column min-vh-100">
@include('layouts.Nav')


<form class="searchform" action="{{ route('handovers.pendingSearch') }}" id="form-spot" style="margin-bottom: 0.5rem" method="GET" autocomplete="off">
        <input type="text" name="q" placeholder="Search..." id="search-field">
        <button class="btn btn-danger" type="submit">Search</button>
        <div>
            <a href="{{ route('pendingHandovers') }}">
                <button class="btn btn-danger" type="button">clear search</button></a>
        </div>
        <button class="btn btn-danger" type="button"
            onclick="document.getElementById('pendingForm').submit()">Confirm</button>

            <a href="{{ route('activeHandovers') }}">
                <button class="btn btn-danger" type="button">Cancel</button>
            </a>

</form>
<br>
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
<form id="pendingForm" action="{{ route('handovers.selected') }}" method="POST">
    @csrf
    <div class="table-responsive-xl" id="table-div">
        <table class="table table-hover table-striped table-bordered table-fixed" id="table-main">
            <thead>
                <tr>
                    <th scope="col">select</th>
                    <th scope="col" id="th_nostyle"> @sortablelink('employee.firstname','Firstname')
                        <img src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
                    </th>
                    <th scope="col" id="th_nostyle"> @sortablelink('employee.surname','Surname')
                        <img src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
                    </th>
                    <th scope="col">Location </th>
                    <th scope="col" id="th_nostyle"> @sortablelink('handover_date','Handover Date')
                        <img src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
                    </th>
                    <th scope="col" id="th_nostyle"> @sortablelink('device.inventory_id','Inventory Number')
                        <img src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
                    </th>
                    <th scope="col">Model</th>
                    <th scope="col">Last action by</th>
                </tr>
            </thead>
            @foreach($handovers as $handover)
            <tr>
                <td id="td_nowrap"> <input type="checkbox" name="selectedHandovers[]" value=" {{ $handover->id }}"></td>
                <td id="td_nowrap"> {{ $handover->firstname }} </td>
                <td id="td_nowrap"> {{ $handover->surname }}</td>
                <td id="td_nowrap"> {{ $handover->location_initials }}</td>
                <td id="td_nowrap"> {{ $handover->handover_date->format('d.m.Y') }} </td>
                <td id="td_nowrap">  <a href=" {{ route('devices.edit', $handover->device_id ) }}" style="text-decoration: none; color: black;">{{$handover->inventory_id }}
                    <img src="{{ asset('images/order_icon.png') }}" id="order-icon">
                </a></td>
                <td id="td_nowrap"> {{ $handover->model }}</td>
                <td id="td_nowrap"> {{ $handover->username }} </td>
            </tr>
            @endforeach
        </table>
    </div>
    <div id="page-selecter">
        {!! $handovers->appends(\Request::except('page'))->render() !!} Showing {{($handovers->currentpage()-1)*$handovers->perpage()+1}} to {{$handovers->currentpage()*$handovers->perpage() }} of  {{$handovers->total()}} entries
    </div>
</form>



@include('layouts.Footer')
</body>
</html>
