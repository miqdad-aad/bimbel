@extends('admin.layout')
@section('content')
<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Detail Booking

                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>

            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->

        <!--end::Actions-->
    </div>
    <!--end::Container-->
</div>
<div class="row gy-5 g-xl-8">
    <div class="col-xl-12">
        <div class="card card-xl-stretch mb-5 mb-xl-8">
            <div class="card-body py-3">
                <div class="row">
                    <div class="row">
                        <h2 style="margin-bottom: 20px;">Detail Siswa</h2>
                        <div class="col-xl-4">
                            <label class="form-label" for="text">Nama Siswa</label>
                            <input name="text" value="{{ $data->siswa_booking->nama }}" class="form-control" type="text"
                                readonly>
                        </div>
                        <div class="col-xl-4">
                            <label class="form-label" for="text">Asal Sekolah</label>
                            <input name="text" value="{{ $data->siswa_booking->asal_sekolah }}" class="form-control"
                                type="text" readonly>
                        </div>
                        <div class="col-xl-4">
                            <label class="form-label" for="text">No HP</label>
                            <input name="text" value="{{ $data->siswa_booking->no_hp }}" class="form-control"
                                type="text" readonly>
                        </div>
                        <div class="col-xl-12">
                            <label class="form-label" for="text">Alamat</label>
                            <input name="text" value="{{ $data->siswa_booking->alamat }}" class="form-control"
                                type="text" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <h2 style="margin-bottom: 20px; margin-top: 20px;">Detail Booking Yang dipesan</h2>
                        <div class="col-xl-6">
                            <label class="form-label" for="text">Jenis Pembayaran</label>
                            <input name="text" value="{{ $data->jenis_pembayaran }}" class="form-control" type="text"
                                readonly>
                        </div>
                        <div class="col-xl-6">
                            <label class="form-label" for="text">Status Pembayaran</label>
                            <input name="text" value="{{ $data->status_pembayaran }}" class="form-control" type="text"
                                readonly>
                        </div>
                        <div class="col-xl-6">
                            <label class="form-label" for="text">Nama Paket Bimbel</label>
                            <input name="text" value="{{ $data->paket_booking->nama_paket_bimbel }}"
                                class="form-control" type="text" readonly>
                        </div>
                        <div class="col-xl-6">
                            <label class="form-label" for="text">Harga Paket Bimbel</label>
                            <input name="text" value="Rp. {{ $data->paket_booking->harga_paket_bimbel }}"
                                class="form-control" type="text" readonly>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <label class="form-label" for="text">Foto Transaksi Pembayaran</label>
                        <input name="file_struktur" class="form-control file-input-struktur" type="file">
                    </div>
                </div>
                <button style="margin-top: 20px" onclick="history.back()" class="btn btn-primary" id="kt_contact_submit_button">
                    <!--begin::Indicator-->
                    <span class="indicator-label">Back</span>
                    <!--end::Indicator-->
                </button>
            </div>
        </div>
    </div>
</div>
<div class="card-footer">
</div>
@endsection
@section('page-js')
<script>
    var path = "{{ asset('bukti_bayar/'. $data->foto_pembayaran) }}";
    $(".file-input-struktur").fileinput({
        'showUpload': false,
        'previewFileType': 'any',
        initialPreview: [
            `<img src='${path}' class='file-preview-image' alt='Desert' title='Desert'>`
        ]
    });

</script>
<script>


</script>
@endsection
