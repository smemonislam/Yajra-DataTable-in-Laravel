<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request )
    {
       $employee =  Employee::query();
        if( $request->ajax() ){
            return DataTables::of($employee)
            ->addIndexColumn()
            ->addColumn('action', function($row){  
                $btn = '<a href="#editEmployeeModal" data-id="'. $row->id .'" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>';
                $btn .= '<a href="#deleteEmployeeModal" data-id="'. $row->id .'" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }


        return view('employee');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email',
            'address'   => 'required',
            'phone'     => 'required|digits:11'
        ]);

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'address'   => $request->address,
            'phone'     => $request->phone,
        ];

        Employee::create($data);
        return response()->json(['success' => 'Employee add successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee =  Employee::find($id);
        $html ='    <div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control" value="'. $employee->name .'" required>
                        <span class="error-name error-messages text-danger"></span>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="email" class="form-control" value="'. $employee->email .'" required>
                        <span class="error-email error-messages text-danger"></span>
					</div>
					<div class="form-group">
						<label>Address</label>
						<textarea name="address" class="form-control" required>'. $employee->address .'</textarea>
                        <span class="error-address error-messages text-danger"></span>
					</div>
					<div class="form-group">
						<label>Phone</label>
						<input type="text" name="phone" class="form-control" value="'. $employee->phone .'" required>
                        <span class="error-phone error-messages text-danger"></span>
					</div>	
                ';
        return response()->json(['html' => $html]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email',
            'address'   => 'required',
            'phone'     => 'required|digits:11'
        ]);

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'address'   => $request->address,
            'phone'     => $request->phone,
        ];

        Employee::where('id', $id)->update($data);
        return response()->json(['success' => 'Employee update successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Employee::where('id', $id)->delete();
        return response()->json(['success' => 'Employee delete successfully.']);
    }
}
