@extends('admin.layout')
@section('content')
<div class="row gy-5 g-xl-8">
    <div class="col-xl-12">
        <div class="card card-xl-stretch mb-5 mb-xl-8">
            <div class="card-body py-3">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="btn-group">
                            <a href="" class="btn btn-primary mdi mdi-plus"><i
                                class="fas fa-sync-alt"></i></a>
                            <a href="" class="btn btn-sm btn-light text-muted"><i
                                    class="fas fa-sync-alt"></i></a>&nbsp;&nbsp;
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group d-flex">
                            <select class="form-select" data-control="select2" data-hide-search="true"
                                class="form-select form-select-sm" style="max-width: 180px" id="filterOption">
                                <option value="bank_code">Bank Code</option>
                                <option value="bank_name">Bank Name</option>
                            </select>
                            &nbsp;
                            <input class="form-control form-control-sm" type="search" id="valueSearch"
                                placeholder="Search..." aria-label="Search" style="max-width:260px">
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 fs-9"
                        id="myTableYajra">
                        <div id="datatable-buttons_wrapper"></div>
                        <thead>
                            <tr>
                                <th>Bank Code</th>
                                <th>Banks Name</th>
                                <th>Account Bank No</th>
                                <th>Account Bank Name</th>
                                <th>Bank Address</th>
                                <th>Bank Branch</th>
                                <th>User Input</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection