<div class="container">
    <div class="wrapper">
        <div class="container text-center" id="logo-container">
            <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/DeviceManager-logo.png') }}" id="header-logo"></a>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light" id="navbar-main">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav nav-fill w-100 me-auto mb-2 mb-lg-0" id="navbar-lane">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Device
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown" id="navbar-dropdown">
                                    <li><a class="dropdown-item hover-effect" id="navDropdownItem" href=" {{ route('devices.index') }}">Overview</a></li>
                                    <li><a class="dropdown-item hover-effect" id="navDropdownItem" href=" {{ route('devices.create') }}">Add</a></li>
                                    <li><a class="dropdown-item hover-effect" id="navDropdownItem" href=" {{ route('stationaryDevices') }}">Stationary</a></li>
                                    <li><a class="dropdown-item hover-effect" id="navDropdownItem" href=" {{ route('orders.index') }}">Orders</a></li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('handovers.create') }}">OnBoarding</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    OffBoarding
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown" id="navbar-dropdown">
                                    <li><a class="dropdown-item hover-effect" id="navDropdownItem" href=" {{ route('activeHandovers') }}">Return devices</a></li>
                                    <li><a class="dropdown-item hover-effect" id="navDropdownItem" href=" {{ route('pendingHandovers') }}">Pending</a></li>
                                    <li><a class="dropdown-item hover-effect" id="navDropdownItem" href=" {{ route('handovers.index') }}">All handovers</a></li>
                                </ul>
                            </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Admin
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown" id="navbar-dropdown">
                            <li><a class="dropdown-item hover-effect" id="navDropdownItem" href="{{ route('devicemodels.index') }}">Edit Devicemodels</a></li>
                            <li><a class="dropdown-item hover-effect" id="navDropdownItem" href=" {{ route('locations.index') }}">Edit Locations</a></li>
                            <li><a class="dropdown-item hover-effect" id="navDropdownItem" href=" {{ route('types.index') }}">Edit Types</a></li>
                            <li><a class="dropdown-item hover-effect" id="navDropdownItem" href=" {{ route('users.index') }}">Users</a></li>
                            <li><a class="dropdown-item hover-effect" id="navDropdownItem" href=" {{ route('employees.index') }}">Employees</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
