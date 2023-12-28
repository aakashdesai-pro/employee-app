@extends('layout.app')
@section('content')
<h1 class="my-2">Dashboard</h1>
<div class="d-flex justify-content-evenly mb-5">
    <div class="card p-2 w-50 mx-1">
        <h3>Department wise highest salary of employees</h3>
        <table class="table table-primary table-striped">
            <thead>
                <tr>
                    <th>Department</th>
                    <th>Highest Salary</th>
                    <th>Employee Name</th>
                </tr>
                @foreach ($departmentWiseHigherSalary as $rec)
                <tr>
                    <td>{{ $rec->department_name}}</td>
                    <td>{{ $rec->employee_name}}</td>
                    <td>{{ $rec->highest_salary }}</td>
                </tr>
                @endforeach
            </thead>
        </table>
    </div>

    <div class="card p-2 w-50 mx-1">
        <h3>Salary range wise employee count</h3>
        <table class="table table-primary table-striped">
            <thead>
                <tr>
                    <th>Salary Range</th>
                    <th>Employee's</th>
                </tr>
                @foreach ($salaryRangeWiseEmployees as $rec)
                <tr>
                    <td>{{ $rec->salary_range}}</td>
                    <td>{{ $rec->employee_count }}</td>
                </tr>
                @endforeach
            </thead>
        </table>
    </div>

    <div class="card p-2 w-50 mx-1">
        <h3>Youngest employee of each department</h3>
        <table class="table table-primary table-striped">
            <thead>
                <tr>
                    <th>Department</th>
                    <th>Employee Name</th>
                    <th>Age</th>
                </tr>
                @foreach ($youngestEmployeeByDepartment as $rec)
                <tr>
                    <td>{{ $rec->department_name}}</td>
                    <td>{{ $rec->employee_name }}</td>
                    <td>{{ $rec->age }}</td>
                </tr>
                @endforeach
            </thead>
        </table>
    </div>
</div>
<div class="d-flex justify-content-between align-items-center">
    <h1>Employees</h1>
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#employeeAddModel">
            Add New Employee
        </button>
    </div>
</div>
<div>
    <table class="table table-primary table-striped my-5">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Photo</th>
                <th scope="col">Department ID</th>
                <th scope="col">Department Name</th>
                <th scope="col">Name</th>
                <th scope="col">DOB</th>
                <th scope="col">Phone</th>
                <th scope="col">Email</th>
                <th scope="col">Salary</th>
                <th scope="col">Status</th>
                <th scope="col">Created At</th>
                <th scope="col">Updated At</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            <tr>
                <td>{{ $employee->id }}</td>
                <td><img style="height: 50px; width:50px" src="{{ $employee->photo_url }}" alt="assd"></td>
                <td>{{ $employee->department->id}}</td>
                <td>{{ $employee->department->name }}</td>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->dob->format('d/m/Y') }}</td>
                <td>{{ $employee->phone }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->salary }}</td>
                <td>{{ $employee->status }}</td>
                <td>{{ $employee->created_at }}</td>
                <td>{{ $employee->updated_at }}</td>
                <td>
                    <button type="button" class="btn btn-success" onclick="setEditEmployeeDetails('{{ $employee->id }}')">Edit</button>
                    <button type="button" class="btn btn-danger" onclick="deleteEmployee('{{ $employee->id }}')">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{ $employees->links() }}
    </div>
</div>


{{-- add employee modal --}}
<div class="modal fade" id="employeeAddModel" tabindex="-1" aria-labelledby="employeeAddModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employeeAddModelLabel">Add New Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row" id="employeeAddForm">
                    <div class="form-group mb-3 col-md-12">
                        <label class="form-label">Photo <span class="text-danger">*</span></label>
                        <input type="file" name="photo" accept="image/*" class="form-control">
                    </div>
                    <div class="form-group mb-3 col-md-6">
                        <label class="form-label">Department <span class="text-danger">*</span></label>
                        <select name="department" class="form-select">
                            <option value="" selected>---Select---</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3 col-md-6">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter employee name">
                    </div>
                    <div class="form-group mb-3 col-md-6">
                        <label class="form-label">Date Of Birth <span class="text-danger">*</span></label>
                        <input type="date" name="dob" class="form-control">
                    </div>
                    <div class="form-group mb-3 col-md-6">
                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" class="form-control" placeholder="e.g. 9999911111">
                    </div>
                    <div class="form-group mb-3 col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="e.g. xyz@email.com">
                    </div>
                    <div class="form-group mb-3 col-md-6">
                        <label class="form-label">Salary <span class="text-danger">*</span></label>
                        <input type="number" name="salary" class="form-control" placeholder="e.g. 55000">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="employeeAddSaveBtn">
                    <div class="spinner-border spinner-border-sm" role="status" id="employeeAddSpinner">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>


{{-- edit employee modal --}}
<div class="modal fade" id="employeeEditModal" tabindex="-1" aria-labelledby="employeeEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employeeEditModalLabel">Edit Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row" id="employeeEditForm">
                    <input type="hidden" id="employee_id" name="employee_id" value="">

                    <div class="form-group mb-3 col-md-6">
                        <label>Current Photo</label>
                        <img src="" id="oldPhoto" name="oldPhoto" style="height: 100px; width:100px">
                    </div>
                    <div class="form-group mb-3 col-md-12">
                        <label class="form-label">Photo <span class="text-danger">*</span></label>
                        <input type="file" id="photo" name="photo" accept="image/*" class="form-control">
                    </div>
                    <div class="form-group mb-3 col-md-6">
                        <label class="form-label">Department <span class="text-danger">*</span></label>
                        <select id="department" name="department" class="form-select">
                            <option value="" selected>---Select---</option>
                            @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3 col-md-6">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter employee name">
                    </div>
                    <div class="form-group mb-3 col-md-6">
                        <label class="form-label">Date Of Birth <span class="text-danger">*</span></label>
                        <input type="date" id="dob" name="dob" class="form-control">
                    </div>
                    <div class="form-group mb-3 col-md-6">
                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="tel" id="phone" name="phone" class="form-control" placeholder="e.g. 9999911111">
                    </div>
                    <div class="form-group mb-3 col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="e.g. xyz@email.com">
                    </div>
                    <div class="form-group mb-3 col-md-6">
                        <label class="form-label">Salary <span class="text-danger">*</span></label>
                        <input type="number" id="salary" name="salary" class="form-control" placeholder="e.g. 55000">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="employeeEditSaveBtn">
                    <div class="spinner-border spinner-border-sm" role="status" id="employeeEditSpinner">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    $(document).ready(function () {

        // employee Add Form START
        let employeeAddModel = $('#employeeAddModel');
        let employeeAddSaveBtn = $('#employeeAddSaveBtn');
        let employeeAddForm = $('#employeeAddForm');
        let employeeAddSpinner = $('#employeeAddSpinner');

        employeeAddSpinner.hide();
        employeeAddSaveBtn.click(function () {
            employeeAddSaveBtn.prop('disabled', true);
            employeeAddSpinner.show();
            $.post({
                url: '{{ route("employee.store") }}',
                data: new FormData(employeeAddForm[0]),
                processData: false,
                contentType: false,
                success: function (response) {
                    alert('Employee Added Successfully');
                    location.reload();
                },
                error: function (error) {
                    alert(error.responseJSON.error);
                    employeeAddSpinner.hide();
                    employeeAddSaveBtn.removeAttr('disabled');
                }
            });
        });
        // employee Add Form END 

        // employee Edit Form START
        let employeeEditSaveBtn = $('#employeeEditSaveBtn');
        let employeeEditSpinner = $('#employeeEditSpinner');
        
        employeeEditSpinner.hide();
        employeeEditSaveBtn.click(function () {
            let employeeEditModal = $('#employeeEditModal');
            let employeeEditForm = $('#employeeEditForm');
            let employee_id = $("#employee_id").val();
            employeeEditSaveBtn.prop('disabled', true);
            employeeEditSpinner.show();
            $.post({
                url: 'employee/update/'+employee_id,
                data: new FormData(employeeEditForm[0]),
                processData: false,
                contentType: false,
                success: function (response) {
                    alert('Employee Updated Successfully');
                    location.reload();
                },
                error: function (error) {
                    alert(error.responseJSON.error);
                    employeeEditSpinner.hide();
                    employeeEditSaveBtn.removeAttr('disabled');
                }
            });
        });
        // employee Edit Form END 
    });
    
    function deleteEmployee(id) {
        let isConfirmed = confirm('Are you sure ?');
        if (isConfirmed) {
            $.post({
                url: "/employee/delete/"+id,
                success: function (response) {
                    alert('Employee Deleted Successfully');
                    location.reload();
                },
                error: function (error) {
                    alert(error.responseJSON.error);
                }
            });
        }
    }

    function setEditEmployeeDetails(id){
        let employeeEditModal = $('#employeeEditModal');
        let employeeEditSpinner = $("#employeeEditSpinner");
        employeeEditSpinner.hide();
        let oldPhoto = $('#oldPhoto');
        let department = $('#department');
        let name = $('#name');
        let dob = $('#dob');
        let phone = $('#phone');
        let email = $('#email');
        let salary = $('#salary');
        let employee_id_main = $('#employee_id');

        $.get({
            url: "employee/show/"+id,
            success: function (response) {
                employee_id_main.val(response.data.id);
                oldPhoto.attr('src', response.data.photo_url);
                department.val(response.data.department_id);
                name.val(response.data.name);
                dob.val(response.data.dob);
                phone.val(response.data.phone);
                email.val(response.data.email);
                salary.val(response.data.salary);
                employeeEditModal.modal('show');
            },
            error: function (errors) {
                alert(errors.responseJSON);
            }
        });
    }


</script>
@endsection