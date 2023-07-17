<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceRequests\StationaryEditFormDataRequest;
use App\Models\Device;
use App\Models\Location;
use App\Models\Status;
use Illuminate\Http\Request;

class StationaryController extends Controller
{
    public function index()
    {
        $devices = Device::isStationary(true)
            ->with(['order', 'location', 'status', 'devicemodel'])
            ->sortable()
            ->orderby('updated_at', 'desc')
            ->paginate(30)
            ->withQueryString();
        return view('devices.stationary.index', compact('devices'));
    }

    public function edit($id)
    {
        $device = Device::where('id', $id)->first();
        $location = Location::whereNot('id', $device->location_id)
            ->select('id','location_initials')->get();
        $status = Status::whereNot('id',$device->status_id)
                        ->select('id','status_name')
                        ->get();

        return view('devices.stationary.edit', compact(['device','location','status']));
    }

    public function update(StationaryEditFormDataRequest $request, $id)
    {
        Device::where('id', $id)->update($request->validated());
        return redirect()->route('stationaryDevices')->with('success','Device information successfully changed');
    }


    public function stationarySearch(Request $request)
    {
        if(!$request->filled('q'))
            return back();

        $query = $request->input('q');
        $devices = Device::isStationary(true)
            ->where(function($q) use($query) {
                $q->where('inventory_id', 'like', "%$query%")
                    ->orWhere('serial_tag', 'like', "%$query%")
                    ->orWhere('imei', 'like', "%$query%")
                    ->orWhereHas('location', function($q) use($query) {
                        $q->where('location_initials', 'like', "%$query%");
                    })
                    ->orWhereHas('devicemodel.types', function($q) use($query) {
                        $q->where('model', 'like', "%$query%")
                            ->orWhere('vendor', 'like', "%$query%")
                            ->orWhere('type_initials', 'like', "%$query%")
                            ->orwhere('type_name', 'like', "%$query%");
                    })
                    ->orWhereHas('order', function($q) use($query) {
                        $q->where('order_id', 'like', "%$query%")
                            ->orWhereDate('order_date', 'like', "%$query%");
                    });
            })
            ->sortable()
            ->paginate(30)
            ->withQueryString();


        return view('devices.stationary.index', compact('devices'));
    }
}
