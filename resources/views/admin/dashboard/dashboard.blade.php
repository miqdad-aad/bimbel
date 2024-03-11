@extends('admin.layout')
@section('content')
<h1>KATEGORI SOAL TERSEDIA</h1>
<div class="row g-5 g-xl-10 mb-xl-10">
    @foreach ($data as $item)
    <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10" style="height: 500px;">
        <div class="card card-flush h-md-50 mb-5 mb-xl-10">
            <div class="card-header pt-5">
                <div class="card-title d-flex flex-column">
                    <div class="d-flex align-items-center">
                        <span class="fs-2hx fw-bolder text-dark me-2 lh-1" style="font-size: 1rem !important;">{{ $item->jenis_tes }}</span>
                    </div>
                </div>
            </div>
            <div class="card-body pt-2 pb-4 d-flex align-items-center">
                <div class="d-flex flex-column content-justify-center w-100">
                    <div class="d-flex fs-6 fw-bold align-items-center">
                        <div class="bullet w-8px h-6px rounded-2 bg-danger me-3"></div>
                        <div class="text-gray-500 flex-grow-1 me-4">Total Soal</div>
                        <div class="fw-boldest text-gray-700 text-xxl-end">$7,660</div>
                    </div>
                    <div class="d-flex fs-6 fw-bold align-items-center my-3">
                        <div class="bullet w-8px h-6px rounded-2 bg-primary me-3"></div>
                        <div class="text-gray-500 flex-grow-1 me-4">Yang Sudah Dikerjakan</div>
                        <div class="fw-boldest text-gray-700 text-xxl-end">$2,820</div>
                    </div>
                    <div class="d-flex fs-6 fw-bold align-items-center">
                        <div class="bullet w-8px h-6px rounded-2 me-3" style="background-color: #E4E6EF"></div>
                        <div class="text-gray-500 flex-grow-1 me-4">Jawaban Benar</div>
                        <div class="fw-boldest text-gray-700 text-xxl-end">$45,257</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
