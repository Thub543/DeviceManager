<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.Head')
    <title>Asset Management</title>
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container text-center" id="logo-container">
            <img src="{{ asset('images/belfor_header_logo.png') }}" id="header-logo">
    </div>
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form class="searchform" id="form-spot" action="{{ route('activeHandoverSearch.RO') }}" method="GET" style="margin-bottom: 0.5rem">
    <input type="text" name="q" placeholder="Search..." id="search-field">
        <button class="btn btn-danger" type="submit">Search</button>
        <a href="{{ route('activeHandover.RO') }}">
            <button class="btn btn-danger" type="button">clear search</button></a>
</form>
<div class="table-responsive-xl" id="table-div">
    <table class="table table-hover table-striped table-bordered table-fixed" id="table-main">
        <thead>
            <tr>
                <th scope="col" id="th_nostyle"> @sortablelink('employee.firstname','Firstname')
                    <img src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
                </th>
                <th scope="col" id="th_nostyle"> @sortablelink('employee.surname','Surname')
                    <img src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
                </th>
                <th scope="col"> Location </th>
                <th scope="col" id="th_nostyle"> @sortablelink('handover_date','Handover Date')
                    <img src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
                </th>
                <th scope="col" id="th_nostyle"> @sortablelink('device.inventory_id','Inventory Number')
                    <img src="{{ asset('images/sort_icon.png') }}" id="sort-icon">
                </th>
                <th scope="col"> Model</th>
            </tr>
        </thead>
        @foreach($handovers as $handover)

            <tr>

                <td id="td_nowrap"> {{ $handover->employee->firstname }} </td>
                <td id="td_nowrap"> {{ $handover->employee->surname }}</td>
                <td id="td_nowrap"> {{ $handover->device->location->location_initials }}</td>
                <td id="td_nowrap"> {{ $handover->handover_date->format('d.m.Y') }} </td>
                <td id="td_nowrap">  {{$handover->device->inventory_id }}</a></td>
                <td id="td_nowrap"> {{ $handover->device->devicemodel->model }}</td>
            </tr>
        @endforeach
    </table>
</div>
<div id="page-selecter">
    {!! $handovers->appends(\Request::except('page'))->render() !!}
</div>

<!-- Footer -->
<footer class="page-footer mt-auto" id="footer-main">

  <!-- Footer Links -->
  <div class="container text-center text-md-left">

    <!-- Grid row -->
    <div class="row" id="footer-row">

      <!-- Grid column -->
      <div class="col-md-3" id="left-footer-side">

        <img class="img-fluid" src="{{ asset('images/belfor_footer_logo.png') }}" id="footer-logo">

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-3" id="secleft-footer-side">

        <ul id="left-footer-list">
          <li>
            <h5 id="left-footer-list-h">BELFOR Austria GmbH</h5>
          </li>
          <li>
            <p id="left-footer-list-text">Großmarktstraße 8</p>
          </li>
          <li>
            <p id="left-footer-list-text-2">1230 Wien</p>
          </li>
        </ul>

      </div>

      <div class="col-md-3" id="right-footer-side">

        

      </div>

      <div class="col-md-3" id="secright-footer-side">

        <ul id="secright-footer-list">
            <li>
                <a href=" {{ route('logout') }}" id="right-footer-list-text">Logout</a> (Logged in as {{ Auth::user()->username }})
            </li>
        </ul>

      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </div>
  <!-- Footer Links -->

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3" id="bottom-footer-line">© 2023 Copyright: BELFOR Austria GmbH
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->

</body>
</html>
