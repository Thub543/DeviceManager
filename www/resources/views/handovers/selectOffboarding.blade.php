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
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form class="searchform" action="{{ route('handovers.search') }}" method="GET" id="form-spot" style="margin-bottom: 0.5rem" autocomplete="off">
        <input type="text" name="q" placeholder="Search..." id="search-field">
        <button class="btn btn-danger" type="submit">Search</button>
        <div>
            <a href="{{ route('activeHandovers') }}">
                <button class="btn btn-danger" type="button">clear search</button>
            </a>
        </div>
        <button class="btn btn-danger" type="button" onclick="document.getElementById('offboardingForm').submit()">start offboarding</button>
</form>
<form id="offboardingForm" action="{{ route('handovers.selected') }}" method="POST">
@csrf
<div class="table-responsive-xl" id="table-div">
    <table class="table table-hover table-striped table-bordered table-fixed" id="table-main">
        <thead>
            <tr>
                <th scope="col">select</th>
                <th scope="col" id="th_nostyle"> @sortablelink('employee.firstname','Firstname')
                    <img alt="" src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
                </th>
                <th scope="col" id="th_nostyle"> @sortablelink('employee.surname','Surname')
                    <img alt="" src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
                </th>
                <th scope="col"> Location </th>
                <th scope="col" id="th_nostyle"> @sortablelink('handover_date','Handover Date')
                    <img alt="" src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
                </th>
                <th scope="col" id="th_nostyle"> @sortablelink('device.inventory_id','Inventory Number')
                    <img alt="" src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
                </th>
                <th scope="col">Model</th>
            </tr>
        </thead>
        @foreach($handovers as $handover)
            <tr>
                <td id="td_nowrap"> <input type="checkbox" name="selectedHandovers[]" value=" {{ $handover->id }}"></td>
                <td id="td_nowrap"> {{ $handover->firstname }} </td>
                <td id="td_nowrap"> {{ $handover->surname }}</td>
                <td id="td_nowrap"> {{ $handover->location_initials }}</td>
                <td id="td_nowrap"> {{ $handover->handover_date->format('d.m.Y') }} </td>
                <td id="td_nowrap">  <a href=" {{ route('devices.edit', ['device' => $handover->device_id] ) }}" style="text-decoration: none; color: black;">{{$handover->inventory_id }}
                        <img src="{{ asset('images/order_icon.png') }}" id="order-icon">
                    </a></td>
                <td id="td_nowrap"> {{ $handover->model }}</td>
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
