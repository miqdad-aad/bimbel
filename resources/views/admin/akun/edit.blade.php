@extends('admin.layout')
@section('content')
<div class="post col-sm-6 d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Contact-->
        <div class="card">
            <!--begin::Body-->
            <div class="card-body p-lg-17">
                <!--begin::Row-->
                <div class="row mb-3">
                    <!--begin::Col-->
                    <div class="col-md-12 pe-lg-10">
                        <!--begin::Form-->
                        <form action="{{ url('updateAkun') }}" class="form mb-15" method="post" id="kt_contact_form">
                            @csrf
                            <input type="text" value="{{ $data->id }}" name="id_user" hidden>
                            <h1 class="fw-bolder text-dark  mb-9">Edit User</h1>
                            <!--begin::Input group-->
                            <div class="row mb-6 col-sm-12">
                                <!--begin::Col-->
                                <div class="col-md-6 fv-row">
                                    <label class="fs-5 fw-bold mb-2">Nama</label>
                                    <input type="text" class="form-control form-control-solid" value="{{ $data->name }}" placeholder="" name="name" />
                                </div>
                                <div class="col-md-6 fv-row">
                                    <label class="fs-5 fw-bold mb-2">Username</label>
                                    <input type="text" class="form-control form-control-solid" value="{{ $data->username }}" placeholder="" name="username" />
                                </div>
                            </div>
                            <div class="d-flex flex-column mb-5 fv-row">
                                <label class="fs-5 fw-bold mb-2">Email</label>
                                <input type="email" class="form-control form-control-solid" value="{{ $data->email }}" placeholder="" name="email" />
                            </div>
                            <div class="d-flex flex-column mb-5 fv-row">                                
                                <label class="fs-5 fw-bold mb-2">password</label>
                                <input type="text" class="form-control form-control-solid" placeholder="" name="password" />                               
                            </div>
                            <button type="submit" class="btn btn-primary" id="kt_contact_submit_button">
                                <!--begin::Indicator-->
                                <span class="indicator-label">Simpan</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                <!--end::Indicator-->
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Contact-->
    </div>
    <!--end::Container-->
</div>
@endsection