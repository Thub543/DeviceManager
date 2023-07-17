<?php

namespace App\Http\Controllers;

use App\Http\Requests\DevicemodelRequests\DevicemodelAddEditRequest;
use App\Models\Device;
use App\Models\DeviceModel;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DevicemodelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * return view
     */
    public function index()
    {
        $devicemodels = DeviceModel::with('types')
                                    ->orderby('updated_at','desc')
                                    ->paginate(30)
                                    ->withQueryString();
        $types = DB::table('types')->get();
        return view('devicemodels.index', compact(['devicemodels','types']));
    }

    /**
     * Store a newly created devicemodel.
     *
     * @param  \Illuminate\Http\Request  $request
     * return \Illuminate\Http\Response
     */
    public function store(DevicemodelAddEditRequest $request)
    {
        DeviceModel::create($request->validated());
        return redirect()->route('devicemodels.index')->with('success','Devicemodel created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!DeviceModel::where('id', $id)->exists()) {
            return redirect()->route('devicemodels.index')->with('error','Devicemodel does not exist');
        }

        $devicemodel = DeviceModel::with('types')->where('id', $id)->first();
        $types =  Type::whereNot('id', $devicemodel->type_id)->get();

        return view('devicemodels.edit',compact(['devicemodel','types']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * return \Illuminate\Http\Response
     */
    public function update(DevicemodelAddEditRequest $request, $id)
    {
        DeviceModel::where('id',$id)->update($request->validated());
        return redirect()->route('devicemodels.index')->with('success','The devicemodel is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
      @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!DeviceModel::where('id',$id)->exists()){
            return back()->with('error','This devicemodel does not exist');
        }
        try {
            DeviceModel::destroy($id);

        } catch (\Exception $e) {
            return back()->with('error','This devicemodel cant be deleted because it used somewhere.');
        }

        return redirect()->route('devicemodels.index')->with('success','The devicemodel is deleted successfully');
    }

    public function devicemodelSearch(Request $request)
    {
        $query = $request->input('q');
        $selectedType = $request->input('types');
        $selectedtypes = collect($selectedType);

        $devicemodels = DeviceModel::where('model', 'like', '%'.$query.'%')
            ->orWhere('vendor', 'like', '%'.$query.'%')
            ->orWhere('os', 'like', '%'.$query.'%')
            ->when($request->filled('types'))->FilterStatus($selectedtypes)
            ->orderBy('updated_at','desc')
            ->paginate(50)
            ->withQueryString();

        $types = DB::table('types')->get();

        return view('devicemodels.index', compact(['devicemodels','types']));
    }
}
