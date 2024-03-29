@extends('layouts.app')
@section('page', 'Employee List')
@section('page_description', 'Employee List')
@section('content')
    <!-- Default ordering table start -->
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-5">
                    <h5>
                        List
                    </h5>
                </div>
                @if (in_array('employee_create', \Auth::user()->permission))
                <div class="col-md-7 text-right">
                    <a href="{{ route('employee.create') }}">
                        <button type="button" class="btn btn-primary btn-sm">Create User</button>
                    </a>
                </div>
                @endif
            </div>
        </div>
        <div class="card-block">
            <div class="dt-responsive table-responsive">
                <table id="order-table" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Employee Code</th>
                            <th>Phone</th>
                            <th>Position</th>
                            <th>Email</th>
                            <th>Branch</th>
                            <th>[ACTION]</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->employee_code }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->position }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->branch ? $item->branch->name : 'All branch' }}</td>
                            <td>
                                @if (in_array('employee_view', \Auth::user()->permission))
                                <a href="{{ route('employee.view', ['employee_code' => $item->employee_code]) }}">
                                    <i class="icon feather icon-eye f-w-600 f-16 m-r-15 text-c-green"></i>
                                </a>
                                @endif
                                @if (in_array('employee_edit', \Auth::user()->permission))
                                <a href="{{ route('employee.edit', ['employee_code' => $item->employee_code]) }}">
                                    <i class="icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green"></i>
                                </a>
                                @endif
                                @if (in_array('employee_delete', \Auth::user()->permission))
                                <a href="{{ route('employee.destroy', ['id' => $item->id]) }}">
                                    <i class="feather icon-trash-2 f-w-600 f-16 text-c-red"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Default ordering table end -->
@endsection