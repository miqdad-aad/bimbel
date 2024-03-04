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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Struktur Organisasi

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
        <form method="post" enctype="multipart/form-data" action="{{ route('masterStrukturOrganisasi.store') }}">
            <div class="card card-xl-stretch mb-5 mb-xl-8">
                <div class="card-body py-3">
                    <div class="row">
                        <div class="col-xl-12">
                            @csrf
                            <label class="form-label" for="text">File Struktur Organisasi</label>
                            <input name="file_struktur" class="form-control file-input-struktur" type="file">
        </form>
    </div>

</div>

</div>
<div class="card-footer">
    <button type="submit" class="btn btn-sm btn-success">Simpan Perubahan</button>
</div>
</div>
</form>
</div>
</div>
@endsection
@section('page-js')
<script>
    $(".file-input-struktur").fileinput({
        'showUpload': false,
        'previewFileType': 'any',
        initialPreview: [
            "<img src='<?= isset($data->foto_pembayaran) ? $data->foto_pembayaran : '' ?>' class='file-preview-image' alt='Desert' title='Desert'>"
        ]
    });

</script>
<script>


</script>
@endsection
