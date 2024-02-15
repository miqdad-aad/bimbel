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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Tambah Sekolah Kedinasan

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
                                <th>Nama Sekolah Kedinasan</th>
                                <th width="250">Action</th>
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
<div class="modal fade" id="modal7" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addmentor">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Form Input Data Sekolah Kedinasan</h5><button type="button" class="btn btn-label-danger btn-icon"
                        data-bs-dismiss="modal"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="form-label" for="text">Nama Sekolah Kedinasan</label>
                            <input name="nama_sekolah_kedinasan" class="form-control nama_sekolah_kedinasan" type="text">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btn-close"
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
        $(".file-barang").fileinput({
            'showUpload': false,
            'previewFileType': 'any',
        });

</script>
<script>
    $(document).ready(function () {

        var _url = $('meta[name="url"]').attr('content');
        var params = null;
        var url = "{{ asset('public/kegiatan/') }}"
        var table = $('#yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            "searching": true,
            filter: true,
            ajax: "{{ route('dataSekolahKedinasan') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'text-center'
                },
                {
                    data: 'nama_sekolah_kedinasan',
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

        $('#addmentor').submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');

            $.ajax({
                type: 'POST',
                url: "{{ route('addSekolahkedinasan') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    if (response) {
                        this.reset();
                        // alert('Image has been uploaded successfully');
                        toastr.success('Sekolah Kedinasan', 'Sudah Dimasukkan');
                        $('#modal7').modal('hide');
                        table.ajax.reload(null, false);
                    }
                },
                error: function (response) {
                    console.log(response);
                    $('#image-input-error').text(response.responseJSON.errors.file);
                }
            });
        });

        $(document).on('click', '#btn-close', function () {
            location.reload();
        });

        let sekolah_id = 0;
        $(document).on('click', '.btn-edit', function () {
            params = table.row($(this).closest('tr')).data();
            sekolah_id = params.id_sekolah_kedinasan;
            $('.nama_sekolah_kedinasan').val(params.nama_sekolah_kedinasan);
            $('.btn-tambah').hide()
            $('.btn-update').show()
            $('#modal7').modal('show');

        });
        $(document).on('click', '.btn-update', function () {
            var nama_sekolah_kedinasan = $('.nama_sekolah_kedinasan').val();
            $('#modal7').modal('show');
            $.ajax({
                url: "{{ route('updateSekolahKedinasan') }}",
                type: "POST",
                data: {
                    id_sekolah_kedinasan: sekolah_id,
                    nama_sekolah_kedinasan: nama_sekolah_kedinasan,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    $('.nama_kategori').val('')
                    toastr.success('Data Sekolah Kedinasan ' + 
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

        $(document).on('click', '.btn-hapus',
            function () {
                params = table.row($(this).closest('tr')).data();

                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Menghapus Kendaraan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Yes, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.get(_url + "/deleteSekolahKedinasan/" + params.id_sekolah_kedinasan, function (data) {
                            toastr.success('Data Kegiatan ' + params.nama_sekolah_kedinasan +
                                ' berhasil di Hapus',
                                'Berhasil !!!');
                            table.ajax.reload(null, false)
                        });
                    }
                })
            })

    });

</script>
@endsection
