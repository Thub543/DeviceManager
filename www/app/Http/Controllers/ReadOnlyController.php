<?php

namespace App\Http\Controllers;

use App\Models\Handover;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReadOnlyController extends Controller
{

    public function getActiveHandovers(){
        $handovers =  Handover::whereNull('Return_Date')
            ->whereHas('device', function($query) {
                $query->whereHas('status', function($subQuery) {
                    $subQuery->where('status_Name', '!=', 'offboarding');
                });
            })->sortable()
            ->orderBy('handovers.id','desc')
            ->orderBy('handovers.updated_at','desc')
            ->paginate(30)
            ->withQueryString();


        return view('readonly/activeHandovers', compact('handovers'));
    }


    public function activeHandoversSearch(Request $request){

        if(!$request->filled('q'))
            return back();

        $q = $request->input('q');

        $handovers = Handover::join('employees as e','handovers.employee_id','=','e.id')
            ->join('devices as d', 'handovers.device_id', '=', 'd.id')
            ->join('devicemodels as dm', 'd.devicemodel_id', '=', 'dm.id')
            ->join('locations as l', 'd.location_id', '=', 'l.id')
            ->select('handovers.id','employee_id', 'e.firstname', 'e.surname', 'handover_date', 'return_date', 'd.inventory_id', 'dm.model','device_id')
            ->whereNull('return_Date')
            ->whereNot('d.status_id',Status::getIdByName('offboarding'))
            ->where(function($query) use ($q) {
                $query->orWhere('e.firstname', 'like', '%'.$q.'%')
                    ->orWhere('e.Surname', 'like', '%'.$q.'%')
                    ->orWhere(DB::raw("concat(firstname, ' ',surname)"), 'LIKE', "%".$q."%")
                    ->orWhere(DB::raw("concat(surname, ' ',firstname)"), 'LIKE', "%".$q."%")
                    ->orWhereDate('handover_date', 'like', '%'.$q.'%')
                    ->orWhere('return_date', 'like', '%'.$q.'%')
                    ->orWhere('d.inventory_id', 'like', '%'.$q.'%')
                    ->orWhere('dm.model', 'like', '%'.$q.'%')
                    ->orWhere('l.location_name', 'like', '%'.$q.'%')
                    ->orWhere('l.location_initials', 'like', '%'.$q.'%')
                    ->whereNull('return_date')
                    ->select('handovers.id', 'employee_id','e.firstname', 'e.surname', 'handover_date', 'return_date', 'd.inventory_id', 'dm.model','device_id');
            })
            ->sortable()
            ->paginate(30)
            ->withQueryString();

        return view('readonly/activeHandovers', compact('handovers'));
    }
}
