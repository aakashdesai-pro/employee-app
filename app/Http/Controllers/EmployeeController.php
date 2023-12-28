<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::paginate(2);
        $departments = Department::all();

        $departmentWiseHigherSalary = DB::select("SELECT d.name AS department_name, e.name AS employee_name, e.salary AS highest_salary FROM employees e JOIN departments d ON e.department_id = d.id WHERE (e.department_id, e.salary) IN ( SELECT department_id, MAX(salary) FROM employees GROUP BY department_id ) AND e.deleted_at IS NULL ORDER BY d.name;");

        $salaryRangeWiseEmployees = DB::select("SELECT CASE WHEN salary BETWEEN 0 AND 50000 THEN '0-50000' WHEN salary BETWEEN 50001 AND 100000 THEN '50001-100000' ELSE '100000+' END AS salary_range, COUNT(*) AS employee_count FROM employees WHERE deleted_at IS NULL GROUP BY salary_range ORDER BY salary_range;");

        $youngestEmployeeByDepartment = DB::select("SELECT d.name AS department_name, e.name AS employee_name, TIMESTAMPDIFF(YEAR, e.dob, CURDATE()) AS age FROM departments d JOIN employees e ON d.id = e.department_id AND e.deleted_at IS NULL JOIN ( SELECT department_id, MAX(dob) AS youngest_dob FROM employees WHERE employees.deleted_at IS NULL GROUP BY department_id ) AS youngest_employees ON e.department_id = youngest_employees.department_id AND e.dob = youngest_employees.youngest_dob; ");

        return view('employee.index', ['employees' => $employees, 'departments' => $departments, 'departmentWiseHigherSalary' => $departmentWiseHigherSalary, 'salaryRangeWiseEmployees' => $salaryRangeWiseEmployees, 'youngestEmployeeByDepartment' => $youngestEmployeeByDepartment]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return EmployeeResource::make($employee);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'photo' => ['required', 'image', 'max:1024'],
            'department' => ['required', 'exists:departments,id'],
            'name' => ['required', 'min:3', 'max:50'],
            'dob' => ['required', 'date'],
            'phone' => ['required', 'digits:10'],
            'email' => ['required', 'email'],
            'salary' => ['required', 'numeric'],
        ]);

        if ($validator->errors()->isNotEmpty()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ],403);
        }

        $employee = Employee::create([
            'department_id' => $request->department,
            'name' => $request->name,
            'dob' => $request->dob,
            'phone' => $request->phone,
            'photo' => '',
            'email' => $request->email,
            'salary' => $request->salary,
        ]);
        
        $file = $request->file('photo');
        $fileName = 'emp_'.$employee->id."_".rand(11111,99999)."_".".jpg";
        $file->move('photos',$fileName);

        $employee->photo = $fileName;
        $employee->save();
        return response()->json([
            'success' => 'Employee Added Successfully'
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $employee = Employee::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'photo' => ['nullable', 'image', 'max:1024'],
            'department' => ['required', 'exists:departments,id'],
            'name' => ['required', 'min:3', 'max:50'],
            'dob' => ['required', 'date'],
            'phone' => ['required', 'digits:10'],
            'email' => ['required', 'email'],
            'salary' => ['required', 'numeric'],
        ]);

        if ($validator->errors()->isNotEmpty()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ],403);
        }

        $employee->department_id = $request->department;
        $employee->name = $request->name;
        $employee->dob = $request->dob;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->salary = $request->salary;
        
        if ($request->has('photo')) {
            $file = $request->file('photo');
            $fileName = 'emp_'.$employee->id."_".rand(11111,99999)."_".".jpg";
            $file->move('photos',$fileName);
            $employee->photo = $fileName;
        }
        
        $employee->save();
        
        return response()->json([
            'success' => 'Employee Added Successfully'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return response()->json([
            'message' => 'Employee Deleted Successfully'
        ], 200);
    }
}
