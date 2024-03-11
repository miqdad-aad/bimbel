@extends('admin.layout')
@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Edit Profile</h1>
                <span class="h-20px border-gray-300 border-start mx-4"></span>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Form-->
            <form id="kt_ecommerce_add_product_form" action="{{ url('updateProfile') }}" enctype="multipart/form-data"
                method="POST" class="form d-flex flex-column flex-lg-row">
                @csrf
                <!--begin::Aside column-->
                <input type="text" value="{{ Auth::user()->id }}" name="userId" hidden />
                <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                    <!--begin::Thumbnail settings-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Foto Profil</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        
                        <!--begin::Card body-->
                        <div class="card-body text-center pt-0">
                            <!--begin::Image input-->
                            <div class="image-input image-input-empty image-input-outline mb-3"
                                data-kt-image-input="true" style="">
                                <!--begin::Preview existing avatar-->
                                @if (Auth::user()->foto_profil == null)
                                <div class="image-input-wrapper w-150px h-150px"
                                    style="background-image: url(https://www.bimbel-militaryinforces.com/img/logo.5a50dbbf.png)">
                                </div>
                                @else
                                <div class="image-input-wrapper w-150px h-150px"
                                    style="background-image: url('../foto_siswa/{{ $data->foto_profil }}')">
                                </div>

                                @endif
                                <!--end::Preview existing avatar-->
                                <!--begin::Label-->
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <!--begin::Inputs-->
                                    <input type="file" name="foto_profil" accept=".png, .jpg, .jpeg" />
                                    <!--end::Inputs-->
                                </label>
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="tab-content">
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                <!--begin::General options-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Profile Anda</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="mb-10 fv-row">
                                            <label class="required form-label">Nama</label>
                                            <input type="text" class="form-control mb-2" placeholder="name"
                                                value="{{ $data->name }}" readonly />
                                        </div>
                                        <div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="form-label">Password Lama</label>
                                                    <input class="form-control form-control-lg form-control-solid"
                                                        type="password" name="password_lama" autocomplete="off" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-label">Password Baru</label>
                                                    <input class="form-control form-control-lg form-control-solid"
                                                        type="password" name="password_baru" autocomplete="off" />
                                                </div>

                                            </div>
                                            <!--end::Description-->
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Tab content-->
                    <div class="d-flex justify-content-end">
                        <!--begin::Button-->
                        <a onclick="history.back()" id="kt_ecommerce_add_product_cancel"
                            class="btn btn-light me-5">Cancel</a>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                            <span class="indicator-label">Save Changes</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                    </div>
                </div>
                <!--end::Main column-->
            </form>
            <!--end::Form-->
            
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
@endsection
