<?php

namespace App\Http\Controllers;

use App\Exports\DeviceExport;
use App\Exports\DeviceFilterExport;
use App\Http\Requests\DeviceRequests\DeviceCreateFormRequest;
use App\Http\Requests\DeviceRequests\DeviceEditFormDataRequest;
use App\Models\Device;
use App\Models\DeviceModel;
use App\Models\Employee;
use App\Models\Handover;
use App\Models\Location;
use App\Models\Order;
use App\Models\Status;
use App\Models\Type;
use App\Services\DeviceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class DeviceController extends Controller
{
    private DeviceService $deviceService;

    public function __construct(DeviceService $deviceService){
        $this->deviceService = $deviceService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $devices = Device::isStationary(false)
                        ->overviewDevices()
                        ->orderby('devices.updated_at','desc')
                        ->paginate(30)
                        ->withQueryString();

        if (!Status::first()) {
            $status = [];
        }

        $status = Status::select('id', 'status_name')->get();

        $isFilter = false;

        return view('devices.index', compact(['devices','status','isFilter']));
    }

    /**
     * Show the form for creating a new Device.
     *
     * return \Illuminate\Http\Response
     */
    public function create()
    {
        $models = DeviceModel::all();
        $type = Type::all();
        $status = Status::GetStatusesByName(['ordered','in Store'])->get();
        $locations = Location::all();

        return view('devices.create', compact(['models', 'type', 'status', 'locations']));
    }

    /**
     * Store a new Device
     *
     * @param  \Illuminate\Http\Request  $request
     * return \Illuminate\Http\Response
     */
    public function store(DeviceCreateFormRequest $request)
    {
        $this->deviceService->store($request);
        return redirect()->route('devices.index')->with('success','Device successfully created');
    }

    /**
     * Show the form for editing the specified device.
     *
     * @param int $id
     * return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $device = Device::with(['order','status', 'devicemodel.types', 'location','users'])->findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('devices.index')->withErrors(['error' => ['Device not found']]);
        }

        $location = Location::whereNot('id', $device->currentEmployee->location_id ?? 0)
                        ->select('id','location_initials')
                        ->get();
        $lastusers = Handover::DeviceHistory($id)->get();
        return view('devices.edit', compact(['device', 'location','lastusers']));
    }

    /**
     * Update the specified device.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * return \Illuminate\Http\Response
     */
    public function update(DeviceEditFormDataRequest $request, int $id)
    {
        $this->deviceService->update($request, $id);
        return redirect()->route('devices.index')
            ->with('success','Device information successfully changed');
    }

    public function editActions(Request $request){
        return $this->deviceService->deviceActions($request);
    }

    /**
     * For the dynamic dropdown in devices/create.blade
     *
     * @param \Illuminate\Http\Request $request
     *
     * */
    public function getModels(Request $request)
    {
        $type = $request->input('type');
        $models = DeviceModel::where('type_id', $type)->get();
        return response()->json($models);
    }

    /**
     * Autocomplete search for the inventory_id in devices/create.blade
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function autocompleteSearch(Request $request)
    {
        $query = $request->get('query');
        $filterResult = Device::isStationary(false)
                                ->where('inventory_id', 'LIKE', '%'. $query. '%')
                                ->where('status_id',Status::getIdByName('in Store'))
                                ->pluck('inventory_id');
        return response()->json($filterResult);
    }

    /**
     * Autocomplete search for the order_id in devices/create.blade
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrdersForDeviceAdd(Request $request){
        $query = $request->get('orderid');
        $filterResult = Order::where('order_id', 'LIKE', '%'. $query. '%')
                            ->orderBy('order_date','desc')
                            ->select('id','order_id','order_date')->get();
        return response()->json($filterResult);
    }



    public function deviceOverviewSearch(Request $request){

        $query = $request->input('q');
        $selectedStatus = collect($request->input('status'));

        if (!$request->filled('q') && !$request->filled('status'))
            return back();

        $devices = Device::searchDevices($query, $selectedStatus);

        if ($request->input('action') === 'filtered') {
            return Excel::download(new DeviceFilterExport(
                $this->deviceService->prepareArrForXlsxExport($devices->get())),
                'devices-'.now()->toDateString().'.xlsx');
        }
        $devices = $devices->paginate(30)->withQueryString();

        $status = Status::select('id', 'status_name')->get();
        $isFilter = true;

        return view('devices.index', compact(['devices', 'status', 'isFilter']));
    }

    /**
     * Download the devices as an excel file
     *
     */
    public function export(){
        return Excel::download(new DeviceExport(), 'devices-'.now()->toDateString().'.xlsx');
    }

}
