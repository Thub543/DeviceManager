<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequests\LocationAddEditRequest;
use App\Models\Location;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = DB::table('locations')->orderby('updated_at','desc')->get();
        return view('locations.index',compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * return \Illuminate\Http\Response
     */
    public function store(LocationAddEditRequest $request)
    {
        Location::create($request->validated());

        return redirect()->route('locations.index')->with('success','Location successfully created');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Location::where('id', $id)->exists()) {
            return redirect()->route('locations.index')->with('error','Location does not exist');
        }
        $location = DB::table('locations')
                            ->where('id',$id)
                            ->first();
        return view('locations.edit',compact('location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * return \Illuminate\Http\Response
     */
    public function update(LocationAddEditRequest $request, $id)
    {
        Location::where('id',$id)->update($request->validated());

        return redirect()->route('locations.index')->with('success','Location successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Location::where('id',$id)->exists()){
            return back()->with('error','This Location does not exist');
        }
        try {
            Location::destroy($id);

        } catch (\Exception $e) {
            return back()->with('error','This Location cant be deleted because it used somewhere.');
        }

        return redirect()->route('locations.index')->with('success','The Location is deleted successfully');
    }
}
