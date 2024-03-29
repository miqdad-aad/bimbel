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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Tambah Jenis Tes

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
                                <th>Gambar</th>
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
                    <h5 class="modal-title">Form Input Jenis Tes</h5><button type="button" class="btn btn-label-danger btn-icon"
                        data-bs-dismiss="modal"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="form-label" for="text">Nama Jenis Tes</label>
                            <input name="jenis_tes" class="form-control jenis_tes" type="text">
                            <input name="id_jenis_tes" class="form-control jenis_tes" type="text" hidden>
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label" for="text">Foto Jenis Tes</label>
                            <input class="form-control file gambar" id="input-id" name="gambar" type="file"
                                data-preview-file-type="text" required>
                            <p class="text-danger"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " id="btn-close"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-tambah">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade " id="modal8" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addkategori" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Form Input Jenis Tes</h5><button type="button" class="btn btn-label-danger btn-icon"
                        data-bs-dismiss="modal"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="form-label" for="text">Nama Jenis Tes</label>
                            <input name="jenis_tes" class="form-control jenis_tes1" type="text">
                            <input name="id_jenis_tes" class="form-control jenis_tes1" type="text" hidden>
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label" for="text">Foto Jenis Tes</label>
                            <input class="form-control file gambar1" id="input-id" name="gambar1" type="file"
                                data-preview-file-type="text" required>
                            <p class="text-danger"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " id="btn-close"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" style="display:none" class="btn btn-primary btn-update">perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('page-js')
<script>
    $(".gambar").fileinput({
        'showUpload': false,
        'previewFileType': 'any',
    });
</script>
<script>
    $(document).ready(function () {

        var _url = $('meta[name="url"]').attr('content');
        var params = null;
        var url = "{{ asset('public/jenis_tes/') }}";
        var table = $('#yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            "searching": true,
            filter: true,
            ajax: "{{ route('jenisTes') }}",
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
                    data: 'gambar',
                    name: 'name',
                    className: 'text-center',
                    render: function (meta, data, row, type) {
                        return '<img style="max-width: 100px;" src="' + url + '/' + row.gambar +
                            '" />';
                    },
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
                url: "{{ route('addJenisTes') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    if (response) {
                        this.reset();
                        // alert('Image has been uploaded successfully');
                        toastr.success('Jenis Tes', 'Sudah Dimasukkan');
                        $('#modal7').modal('hide');
                        table.ajax.reload(null, false);
                    }
                },
                error: function (response) {
                    console.log(response);
                    toastr.error('Jenis Tes', 'Error');
                    $('#image-input-error').text(response.responseJSON.errors.file);
                }
            });
        });

        let jenis_tes_id = 0;
        $(document).on('click', '.btn-edit', function () {
            params = table.row($(this).closest('tr')).data();
            jenis_tes_id = params.id_jenis_tes;
            $('.jenis_tes1').val(params.jenis_tes);
            $('.btn-tambah').hide()
            $('.btn-update').show()
            $('#modal8').modal('show');

        });
        $(document).on('click', '.btn-update', function () {
            var jenis_tes = $('.jenis_tes1').val();
            var gambar1 = $('.gambar1').val();
            $('#modal8').modal('show');
            $.ajax({
                url: "{{ route('updateJenisTes') }}",
                type: "POST",
                data: {
                    jenis_tes: jenis_tes,
                    gambar1: gambar1,
                    id_jenis_tes: jenis_tes_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    $('.jenis_tes').val('')
                    toastr.success('Data Jenis Tes ' + 
                        ' berhasil di perbarui', 'Berhasil !!!');
                    table.ajax.reload(null, false)
                    $('#modal8').modal('hide');
                },
                error: function (data) {
                    toastr.error(data.responseJSON.message, 'Error !!!');
                    $('#modal8').modal('hide');
                },
            });
        });

    });

</script>
@endsection
