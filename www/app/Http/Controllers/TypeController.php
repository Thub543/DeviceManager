<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeRequests\TypeAddRequest;
use App\Http\Requests\TypeRequests\TypeEditRequest;
use App\Models\Type;
use Illuminate\Support\Facades\DB;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = DB::table('types')->orderby('updated_at','desc')->get();
        return view('types.index',compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * return \Illuminate\Http\Response
     */
    public function store(TypeAddRequest $request)
    {
        Type::create($request->validated());
        return redirect()->route('types.index')->with('success','Type successfully created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Type::where('id', $id)->exists()) {
            return redirect()->route('types.index')->with('error','Type does not exist');
        }

        $type = DB::table('types')->where('id',$id)->first();
        return view('types.edit',compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * return \Illuminate\Http\Response
     */
    public function update(TypeEditRequest $request, $id)
    {
        Type::where('id', $id)->update($request->validated());
        return redirect()->route('types.index')->with('success','Type successfully updated');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Type::where('id',$id)->exists()){
            return back()->with('error','This Type does not exist');
        }
        try {
            Type::destroy($id);
        } catch (\Exception $e) {
            return back()->with('error','This Type cant be deleted because it used somewhere.');
        }
        return redirect()->route('types.index')->with('success','The Type is deleted successfully');
    }
}
