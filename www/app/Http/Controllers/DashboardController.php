<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Collects the necessary data for the dashboard
     * return resources/views/dashboard.blade.php
     */
    public function index()
    {
        //bar chart
        $devicesTypes = DB::table('devices')
            ->join('devicemodels', 'devices.devicemodel_id', '=', 'devicemodels.id')
            ->join('types', 'devicemodels.type_id', '=', 'types.id')
            ->where('types.type_name', 'Smartphone')
            ->orWhere('types.type_name', 'Tablet')
            ->select(DB::raw('COUNT(*) as count'), 'types.type_name')
            ->groupBy('types.id', 'types.type_name')
            ->pluck('count', 'type_name');

        $assignedDevices = DB::table('devices')
            ->join('devicemodels', 'devices.devicemodel_id', '=', 'devicemodels.id')
            ->join('types', 'devicemodels.type_id', '=', 'types.id')
            ->join('statuses', 'devices.status_id', '=', 'statuses.id')
            ->select(DB::raw('COUNT(*) as count'), 'types.type_name')
            ->where('statuses.status_name', '=', 'assigned')
            ->groupBy('types.id', 'types.type_name')
            ->pluck('count', 'type_name');

        $inStoreDevices = DB::table('devices')
            ->join('devicemodels', 'devices.devicemodel_id', '=', 'devicemodels.id')
            ->join('types', 'devicemodels.type_id', '=', 'types.id')
            ->join('statuses', 'devices.status_id', '=', 'statuses.id')
            ->select(DB::raw('COUNT(*) as count'), 'types.type_name')
            ->where('statuses.status_name', '=', 'in Store')
            ->groupBy('types.id', 'types.type_name')
            ->pluck('count', 'type_name');


        //donut chart
        $deviceStates = DB::table('devices')
            ->join('statuses', 'devices.status_id', '=', 'statuses.id')
            ->select(DB::raw('COUNT(*) as count'), 'statuses.status_name')
            ->groupBy('statuses.id', 'statuses.status_name')
            ->pluck('count', 'status_name');

        $lastYear = now()->subYear()->toDateString();
        $handoversHistory = DB::table('handovers')
            ->select(DB::raw('COUNT(*) as count'), DB::raw("DATE_FORMAT(handover_date, '%Y-%m-%d') as handover_date"))
            ->where(DB::raw("DATE(handover_date)"), '>=', $lastYear)
            ->orderBy('handover_date')
            ->groupBy(DB::raw("DATE_FORMAT(handover_date, '%Y-%m-%d')"))
            ->pluck('count', 'handover_date');

        $employeeCount = DB::table('employees')->count();

        $deviceCount = DB::table('devices')->count();

        $devicesOffboarding = DB::table('devices')
            ->join('statuses', 'devices.status_id', '=', 'statuses.id')
            ->where('statuses.status_name', '=', 'offboarding')
            ->count();

        $orderdDevices = DB::table('orders as o')
            ->select(DB::raw('COUNT(*) as count, o.order_id'), 'o.id')
            ->join('devices as d', 'd.order_id', '=', 'o.id')
            ->join('statuses as s', 'd.status_id', '=', 's.id')
            ->where('s.status_name', '=', 'ordered')
            ->groupBy('o.id', 'o.order_id', 'o.id')
            ->get();

        $devicesPerLocation = DB::table('devices')
            ->join('employees', 'devices.current_employee_id', '=', 'employees.id')
            ->join('locations', 'employees.location_id', '=', 'locations.id')
            ->join('devicemodels', 'devices.devicemodel_id', '=', 'devicemodels.id')
            ->join('types', 'devicemodels.type_id', '=', 'types.id')
            ->select('locations.location_name', DB::raw('COUNT(types.type_name) as count'), 'types.type_name')
            ->where('types.type_name', '=', 'Smartphone')
            ->orWhere('types.type_name', '=', 'Tablet')
            ->groupBy('locations.location_name', 'types.type_name')
            ->orderBy('locations.location_name')
            ->get();

        $result = [];
        foreach ($devicesPerLocation as $device) {
            $locationName = $device->location_name;
            $count = $device->count;
            $typeName = $device->type_name;

            if (!isset($result[$locationName])) {
                $result[$locationName] = [];
            }

            $result[$locationName][$typeName] = $count;
        }

        return view('dashboard', compact(['devicesTypes', 'deviceStates', 'assignedDevices',
            'inStoreDevices','handoversHistory', 'employeeCount',
            'devicesOffboarding', 'orderdDevices', 'result',
            'deviceCount']));
    }
}
