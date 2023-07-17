<?php

namespace App\Http\Controllers;


use App\Models\Device;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){
        $orders = Order::select('id','order_id','order_date')
                        ->withCount('devices')
                        ->withCount(['devices as notOrderDevices' => function ($query) {
                            $query->whereNot('status_id', Status::getIdByName('ordered'));
                        }])
                        ->orderBy('order_date','desc')
                        ->paginate(30);

        return view('orders.index', compact(['orders']));
    }

    /**
     * Show the form for editing the specified order.
     *
     * @param int $id
     * return \Illuminate\Http\Response
     */
    public function edit($oid){
        if (!Order::where('id', $oid)->exists()) {
            return redirect()->route('orders.index')->with('error','Order does not exist');
        }
        $devices = Device::with(['devicemodel','status'])->where('order_id',$oid)->get();

        return view('orders.edit', compact(['devices']));
    }

    /**
     *  Change the status of the device to arrived
     *
     * @param Request $request
     * return \Illuminate\Http\Response
     */
    public function markAsArrived(Request $request){

        $request->validate([
            'cbDevices' => 'required'
        ]);
        $devicesIds = $request->cbDevices;
        foreach ($devicesIds as $deviceid){
            Device::where('id', $deviceid)->update([
                'status_id' => Status::getIdByName('in Store'),
                'user_id' => Auth::id(),
            ]);
        }

        return back()->with('success','Succesfully marked as in Store');
    }

    /**
     * Search for oders.index view
     *
     * @param Request $request
     * return \Illuminate\Http\Response
     */
    public function getOrdersSearch(Request $request){
        $searchQuery = $request->input('filter'); // retrieve the search query from the request
        $orders = Order::where('order_id', 'LIKE', '%'. $searchQuery. '%')
            ->orwhereDate('order_date', 'LIKE', '%'. $searchQuery. '%')
            ->withCount('devices')
            ->withCount(['devices as notOrderDevices' => function ($query) {
                $query->whereNot('status_id', Status::getIdByName('ordered'));
            }])
            ->orderBy('order_date','desc')
            ->paginate(30);
        return view('orders.index', compact(['orders']));
    }

}
