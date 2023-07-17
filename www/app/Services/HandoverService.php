<?php

namespace App\Services;

use App\Models\Device;
use App\Models\Employee;
use App\Models\Handover;
use App\Models\Location;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HandoverService
{
    public function store($request){
        $devices = $request->input('devices'); // -> inventory_id's as array
        $employee = Employee::where('id',$request->employeeId)->first();

        foreach ($devices as $device) {

            $deviceid = Device::getIdFromInvId($device);

            Handover::create([
                'employee_id' => $employee->id,
                'device_id' => $deviceid,
                'handover_date' => now(),
                'user_id' => Auth::id(),
            ]);

            Device::where('id', $deviceid)->update([
                'status_id' => Status::getIdByName('assigned'),
                'location_id' => null,
                'current_Employee_id' => $employee->id,
                'user_id' => Auth::id(),
            ]);
        }
    }
    // if the new status is offboarding Return date will not set
    // the location is going to be IT any time except offboarding
    public function updateOffboardingData($request){
        $handovers = $request->input('handoversid');
        $statuses = $request->input('ddStatus');

        for ($i = 0; $i < count($handovers); $i++) {
            $handover = Handover::find($handovers[$i]);
            $status = $statuses[$i];

            Device::where('id',$handover->device_id)->update([
                'status_id' => $status,
                'location_id' => Location::getIt(),
                'user_id' => Auth::id(),
            ]);

            if($status != Status::getIdByName('offboarding') ){
                $handover->update([
                    'return_date' => Carbon::now(),
                    'user_id' => Auth::id(),
                ]);

                Device::where('id',$handover->device_id)->update([
                    'current_employee_id' => null,
                    'last_employee_id' => $handover->employee_id,
                    'user_id' => Auth::id(),
                ]);
            } else {
                $handover->update([
                    'user_id' => Auth::id(),
                ]);
            }
        }
    }

}
