<?php

namespace App\Services;

use App\Models\Device;
use App\Models\Employee;
use App\Models\Handover;
use App\Models\Location;
use App\Models\Order;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DeviceService
{
    public function store($request):void
    {
        if($request->checkOrder === "new"){
            $request->validate([
                'orderid' => 'unique:orders,order_id',
                'orderdate' => 'required|date',
            ]);
            $order = Order::create([
                'order_id' => $request->orderid,
                'order_date' => $request->orderdate
            ]);
        }

        if($request->checkOrder === "extend"){
            $request->validate(['oId' => 'required|exists:orders,id']);
            $order = Order::find($request->oId);
        }

        for ($i = 0; $i < $request->deviceCount; $i++)
        {
            Device::create([
                'inventory_id' => generateInventoryID($request->ddType),
                'order_id' => $order->id,
                'warranty' => $request->warranty,
                'devicemodel_id' => $request->ddModel,
                'status_id' => $request->ddStatus,
                'location_id' => $request->ddLocation,
                'user_id' => Auth::id(),
            ]);
        }
    }

    public function update($request, $id){
        try {
            $device = Device::findOrFail($id);
            $data = $request->validated();
            // appends the request array with the user_id
            $data['user_id'] = Auth::id();
            $device->update($data);
            Employee::updateLocation($device->current_employee_id, $request->location_id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }



    public function prepareArrForXlsxExport($collection){
        $exportDevices = $collection->map(function ($device) {
            return [
                'inventory_id' => $device->inventory_id,
                'device_state' => $device->device_state,
                'current_location_initials' => $device->current_location_initials,
                'dm_model' => $device->model,
                'dm_vendor' => $device->vendor,
                'current_firstname' => $device->current_firstname,
                'current_surname' => $device->current_surname,
                'last_firstname' => $device->last_firstname,
                'last_surname' => $device->last_surname,
                'device_order_id' => $device->oid,
                'device_order_date' => $device->device_order_date, // Replace with the actual date field
                'warranty' => $device->warranty, // Replace with the actual warranty field
                'serial_tag' => $device->serial_tag,
                'imei' => $device->imei,
                'comment' => $device->comment,
            ];
        });
        return $exportDevices;
    }


    public function deviceActions($request) {
        $deviceid = $request->input('deviceid');
        $status = $request->input('action');

        if($status== "recovered") {
            Device::where('id', $deviceid)->update([
                'status_id' => Status::getIdByName("in Store"),
                'location_id' => Location::getIT(),
                'comment' => 'Recovered on ' . now(),
                'user_id' => Auth::id()
            ]);
            return redirect()->route('devices.index')->with('success','Device ' . Device::getInvId($deviceid) . ' successfully marked as recovered');
        }


        $handover = Handover::where('device_id',$deviceid)
            ->whereNull('return_date')->first();

        if (Device::isAssigned($deviceid)) {
            $this->completeHandoverSetLastUser($handover);
        }

        Device::where('id', $deviceid)->update([
            'status_id' => Status::getIdByName($status),
            'location_id' => Location::getIT(),
            'comment' => $status . ' reported on ' . now(),
            'user_id' => Auth::id()
        ]);

        if($status == "in Store") {
            Device::where('id', $deviceid)->update([
                'comment' => 'Quick returned on ' . now(),
                'user_id' => Auth::id()
            ]);
        }

        return redirect()->route('devices.index')->with('success','Device ' . Device::getInvId($deviceid) . ' successfully marked as ' . $status);
    }

    private function completeHandoverSetLastUser($handover){
        Handover::where('id',$handover->id)->update([
            'return_date' => now()
        ]);

        Device::where('id', $handover->device_id)->update([
            'current_employee_id' => null,
            'last_employee_id' => $handover->employee_id
        ]);
    }
}
