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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Tambah Materi Tes

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
                    <div class="col-xl-6">
                        <div class="btn-group">
                            <a class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modal7"><i class="fas fa-plus"></i></a>
                            <a href="" class="btn btn-sm btn-light text-muted"><i
                                    class="fas fa-sync-alt"></i></a>&nbsp;&nbsp;
                        </div>
                    </div>
                    
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 fs-9"
                        id="yajra-datatable">
                        <div id="datatable-buttons_wrapper"></div>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Tes</th>
                                <th>Materi Tes</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="modal7" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addkategori">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Form Input Materi Tes</h5><button type="button" class="btn btn-label-danger btn-icon"
                        data-bs-dismiss="modal"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="form-label" for="text">Jenis Tes</label>
                            <select name="id_jenis_tes" class="form-control ip jenis_tes">
                                <option></option>
                                @foreach ($materi as $item)
                                <option value="{{ $item->id_jenis_tes }}">{{ $item->jenis_tes }}</option>
                                @endforeach
                            </select>
                            <p class="text-danger">{{ $errors->first('category_id') }}</p>
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label" for="text">Kode Materi Tes</label>
                            <input name="kode_materi_tes" class="form-control kode_materi_tes" type="text">
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label" for="text">Nama Materi Tes</label>
                            <input name="materi_tes" class="form-control materi_tes" type="text">
                            <input name="id_materi_tes" class="form-control id_materi_tes" type="text" hidden>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " id="btn-close"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-tambah">Simpan</button>
                    <button type="button" style="display:none" class="btn btn-primary btn-update">perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('page-js')
<script>
    $(document).ready(function () {

        var _url = $('meta[name="url"]').attr('content');
        var params = null;

        var table = $('#yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            "searching": true,
            filter: true,
            ajax: "{{ route('materiTes') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'text-center'
                },
                {
                    data: 'jenis_tes',
                    name: 'name',
                    className: 'text-center'
                },
                {
                    data: 'nama_materi_tes',
                    name: 'name',
                    className: 'text-center'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true,
                    className: 'text-center'
                },
            ]
        });

        $('#addkategori').submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');

            $.ajax({
                type: 'POST',
                url: "{{ route('addMateriTes') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    if (response) {
                        this.reset();
                        // alert('Image has been uploaded successfully');
                        toastr.success('Materi Tes', 'Sudah Dimasukkan');
                        $('#modal7').modal('hide');
                        table.ajax.reload(null, false);
                    }
                },
                error: function (response) {
                    console.log(response);
                    toastr.error('Materi Tes', 'Error');
                    $('#image-input-error').text(response.responseJSON.errors.file);
                }
            });
        });

        let materi_tes_id = 0;
        $(document).on('click', '.btn-edit', function () {
            params = table.row($(this).closest('tr')).data();
            materi_tes_id = params.id_materi_tes;
            $('.jenis_tes').val(params.jenis_tes);
            $('.kode_materi_tes').val(params.kode_materi_tes);
            $('.materi_tes').val(params.nama_materi_tes);
            $('.id_materi_tes').val(params.id_materi_tes);
            $('.btn-tambah').hide()
            $('.btn-update').show()
            $('#modal7').modal('show');

        });
        $(document).on('click', '.btn-update', function () {
            var jenis_tes = $('.jenis_tes').val();
            var kode_materi_tes = $('.kode_materi_tes').val();
            var materi_tes = $('.materi_tes').val();
            var id_materi_tes = $('.id_materi_tes').val();
            $('#modal7').modal('show');
            $.ajax({
                url: "{{ route('updateMateriTes') }}",
                type: "POST",
                data: {
                    id_jenis_tes: jenis_tes,
                    kode_materi_tes: kode_materi_tes,
                    materi_tes: materi_tes,
                    id_materi_tes: id_materi_tes,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    $('.jenis_tes').val('')
                    toastr.success('Data Materi Tes ' + 
                        ' berhasil di perbarui', 'Berhasil !!!');
                    table.ajax.reload(null, false)
                    $('#modal7').modal('hide');
                },
                error: function (data) {
                    toastr.error(data.responseJSON.message, 'Error !!!');
                    $('#modal7').modal('hide');
                },
            });
            $('.btn-save').show()
            $('.btn-update').hide()
        });

    });

</script>
@endsection
