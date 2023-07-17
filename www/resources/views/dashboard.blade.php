<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.Head')
    <title>Asset Management</title>

    <style>
        body{
            min-width: 500px;
        }
        .deviceAmountAndState-barChart-wrapper {
            position: relative;
            margin: auto;
            height: 30vh;
            width: 40vw;
        }

        .allDeviceSates-donutChart-wrapper {
            position: relative;
            margin: auto;
            height: 500px;
            width: 500px;
        }

        .handover-lineChart-wrapper{
            position: relative;
            margin: auto;
            height: 40vh;
            width: 40vw;
        }



        @media (max-width: 1440px){
            .allDeviceSates-donutChart-wrapper {
                position: relative;
                margin: auto;
                height: 400px;
                width: 400px;
            }
            .row{
                margin-bottom: 2rem;
            }
        }

        @media (min-width: 970px){
            .handover-lineChart-wrapper{
                position: relative;
                margin: auto;
                height: 300px !important;
                width: 600px !important;
            }

            .deviceAmountAndState-barChart-wrapper {
                position: relative;
                margin: auto;
                height: 300px;
                width: 500px;
            }
        }

        @media (min-height: 800px) {
            .handover-lineChart-wrapper{
                position: relative;
                margin: auto;
                height: 300px !important;
                width: 500px !important;
            }
        }


        @media (max-width: 970px){
            .handover-lineChart-wrapper{
                position: relative;
                margin: auto;
                height: 300px;
                width: 500px;

            }

            .deviceAmountAndState-barChart-wrapper {
                position: relative;
                margin: auto;
                height: 300px;
                width: 500px;
            }

            .row{
                margin-bottom: 1rem;
            }

            .col-chart{
                height: 300px;
            }
        }

        @media (min-height: 1000px) {
            .handover-lineChart-wrapper {
                position: relative;
                margin: auto;
                height: 30vh;
                width: 40vw;
            }
        }

        .row{
            margin-bottom: 3rem;
            margin-top: 1rem;
        }
</style>
</head>
<body class="d-flex flex-column min-vh-100">
    @include('layouts.Nav')

    @if($deviceCount == 0)
        <div class="container-fluid" id="charts-container" style="margin-bottom: 2rem">
            <div class="row">
                No devices
            </div>
        </div>
    @else
    <div class="container-fluid border border-5" id="charts-container" style="margin-bottom: 2rem">
        <div class="row">
            <div class="col-lg-6" id="col-chart">
                <div class="deviceAmountAndState-barChart-wrapper">
                    <canvas id="deviceAmountAndStateBarChart"></canvas>
                </div>
            </div>
            <div class="col-lg-6" id="col-chart">
                <div class="handover-lineChart-wrapper">
                    <canvas id="handoverHistoryPastYearLineChart"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6" id="col-chart">
                <div class="allDeviceSates-donutChart-wrapper d-flex justify-content-center">
                    <canvas id="allDeviceStatesDonutChart"></canvas>
                </div>
            </div>

            <div class="col-md-6">
                <h3 style="padding-top: 10px">Devices in Order</h3>
                @if($orderdDevices->count() != 0)
                    <table class="table table-hover table-bordered table-fixed" id="table-main">
                        <tr>
                            <th id="Colmn">Order ID</th>
                            <th id="Colmn">Devices not arrived yet</th>
                        </tr>
                        <tbody>
                        <tr>
                        @foreach($orderdDevices as $item)
                            <tr>
                                <td><a href="{{ route('orders.edit', $item->id) }}" style="text-decoration: none; color: black;">{{ $item->order_id }}</a></td>
                                <td>{{ $item->count }}
                                </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                @endif
            </div>



        <div class="row">
            <div class="col-md-6">
                <h3>Active Handovers</h3>
                <table class="table table-hover table-bordered table-fixed" id="table-main">
                    <thead>
                    <tr>
                        <th>Location</th>
                        <th>Smartphone</th>
                        <th>Tablet</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($result as $locationName => $deviceCounts)
                        <tr>
                            <td>{{ $locationName }}</td>
                            <td>{{ isset($deviceCounts['Smartphone']) ? $deviceCounts['Smartphone'] : 0 }}</td>
                            <td>{{ isset($deviceCounts['Tablet']) ? $deviceCounts['Tablet'] : 0 }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-lg-6">
                <h3>Employee and Device Statistics</h3>
                <p>Registered Employees: {{ $employeeCount }}</p>
                <p>Registered Devices: {{ $deviceCount }}</p>
                <p>Devices in offboarding: {{ $devicesOffboarding }}</p>
                @if($orderdDevices->count() == 0)
                    <p>No devices ordered.</p>
                @endif
            </div>
        </div>

        </div>
    </div>
    @endif

    @include('layouts.Footer')
</body>

<script src="{{ asset('/js/ChartsGenerators.js') }} "></script>
<script src="{{ asset('/js/chart.js') }} "></script>

<script type="text/javascript">

    createBarChartDeviceTypes({{ Js::from($devicesTypes)}}, {{ Js::from($assignedDevices) }}, {{ Js::from($inStoreDevices) }});

    createDonutChartStatus({{ Js::from($deviceStates) }});

    createHandoverLineChart({{ Js::from($handoversHistory) }})



</script>
</html>
