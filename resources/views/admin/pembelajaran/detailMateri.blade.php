@extends('admin.layout')
@section('content')

<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-body p-lg-17">
                <div class="mb-18">
                    <div class="mb-10">
                        <div class="text-center mb-15">
                            <h3 class="fs-2hx text-dark mb-5">{{ $data->jenis_tes->jenis_tes }}</h3>
                            <div class="fs-5 text-muted fw-bold">{{ $data->judul_materi }}</div>
                            <div class="fs-5 text-muted">Nama Mentor : {{ $data->mentor->nama_mentor }}</div>
                        </div>
                        <div class="overlay" style="text-align: center; ">
                            <img class=" card-rounded" src="{{ asset('public/pembelajaran/'.$data->gambar) }}" alt="" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="fs-5 fw-bold text-gray-600">
                                <p class="mb-8">{{ $data->uraian_materi }}</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="flex-lg-row-auto w-100 w-lg-275px w-xxl-350px">
                                <div class="card bg-light">
                                    <!--begin::Body-->
                                    <div class="card-body">

                                        <div class="mb-7">

                                            <h2 class="fs-1 text-gray-800 w-bolder mb-6">Materi Tambahan</h2>
                                        </div>
                                        <!--end::Top-->

                                        <div class="mb-8">

                                            <h4 class="text-gray-700 w-bolder mb-0">File</h4>

                                            <!--begin::Section-->
                                            <div class="my-2">
                                                <!--begin::Row-->
                                                <div class="d-flex align-items-center mb-3">
                                                    <!--begin::Bullet-->
                                                    <span class="bullet me-3"></span>
                                                    <!--end::Bullet-->
                                                    <!--begin::Label-->
                                                    <div class="text-gray-600 fw-bold fs-6"><a href="{{ $data->link_materi }}" target="_blank">Klik File Materi</a>
                                                    </div>
                                                    <!--end::Label-->
                                                </div>
                                            </div>
                                            <!--end::Section-->
                                        </div>


                                        <div class="mb-8">

                                            <h4 class="text-gray-700 w-bolder mb-0">Link Vidio</h4>

                                            <!--begin::Section-->
                                            @php
                                                $link = $data->link_video;
                                            @endphp
                                            <iframe width="300" height="200"
                                            src="{{ $link }}">
                                            </iframe>
                                            <div class="text-gray-600 fw-bold fs-6"><a href="{{ $link }}" target="_blank">Klik File video</a>
                                            </div>
                                            <!--end::Section-->
                                        </div>
                                        <!--end::Link-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Careers about-->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::About card-->
    </div>
    <!--end::Container-->
</div>
@endsection
