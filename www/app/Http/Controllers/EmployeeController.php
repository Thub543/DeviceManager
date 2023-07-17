<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Http\Requests\EmployeeRequests\EmployeeAddRequest;
use App\Http\Requests\EmployeeRequests\EmployeeEditRequest;
use App\Imports\EmployeeImport;
use App\Models\Employee;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * return \Illuminate\Http\Response
     */
    public function index()
    {
        $emps = Employee::with('location')
                        ->orderBy('updated_at', 'desc')
                        ->paginate(30);

        $locations = Location::all();

        return view('employees.index', compact(['emps', 'locations']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * return \Illuminate\Http\Response
     */
    public function store(EmployeeAddRequest $request)
    {
        Employee::create($request->validated());

        return back()->with('success', 'Employee added successfully!');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Employee::where('id', $id)->exists()) {
            return redirect()->route('employees.index')->with('error','Employee does not exist');
        }

        $emp =  Employee::with('location')
            ->where('id', $id)
            ->first();
        $locs = Location::whereNot('id', $emp->location_id)
                        ->select('id', 'location_name')->get();

        return view('employees.edit', compact(['emp', 'locs']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * return \Illuminate\Http\Response
     */
    public function update(EmployeeEditRequest $request, $id)
    {
        Employee::where('id',$id)->update($request->validated());

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Employee::where('id',$id)->exists()){
            return back()->with('error','This Employee does not exist');
        }
        try {
            Employee::destroy($id);

        } catch (\Exception $e) {
            return back()->with('error','This Employee cant be deleted because it used somewhere.');
        }

        return redirect()->route('employees.index')->with('success','The Employee is deleted successfully');
    }

    public function getEmployeeForOnboarding(Request $request){

        $searchQuery = $request->input('filter'); // retrieve the search query from the request
        $emps = Employee::join('locations as l','l.id','=','location_id')->where('surname', 'LIKE', '%'. $searchQuery. '%')
            ->orwhere('firstname', 'LIKE', '%'. $searchQuery. '%')
            ->select('employees.id','firstname','surname','personal_number','location_id','location_name')
            ->get();
        return response()->json($emps);
    }

    public function searchEmployee(Request $request){

        $searchQuery = $request->input('filter');
        if($searchQuery == null){
            return back();
        }
        // retrieve the search query from the request
        $emps = Employee::join('locations as l','employees.location_id','=','l.id')
            ->where('surname', 'LIKE', '%'. $searchQuery. '%')
            ->orwhere('firstname', 'LIKE', '%'. $searchQuery. '%')
            ->orwhere('personal_number', 'LIKE', '%'. $searchQuery. '%')
            ->orwhere('l.location_name', 'LIKE', '%'. $searchQuery. '%')
            ->orwhere('l.location_initials', 'LIKE', '%'. $searchQuery. '%')
            ->select('employees.id','employees.firstname','employees.surname','employees.personal_number','employees.location_id','l.location_name')
            ->orderBy('employees.updated_at', 'desc')
            ->paginate(30)
            ->withQueryString();

        $locations = Location::all();
        return view('employees.index', compact(['emps', 'locations']));
    }


    public function export()
    {
        return Excel::download(new EmployeeExport(), 'employees-'.now()->toDateString().'.xlsx');
    }

    /**
     * return \Illuminate\Support\Collection
     */
    public function import()
    {
        try {
            Excel::import(new EmployeeImport(),request()->file('file'));
            return back();
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('ImportError', 'Something went wrong, please check your file and try again'. $th->getMessage());
        }
    }
}
