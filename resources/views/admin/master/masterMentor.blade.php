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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Tambah Mentor

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
                                <th>Nama Tentor</th>
                                <th>Jabatan</th>
                                <th>Gambar</th>
                                <th>Active</th>
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
<div class="modal fade bd-example-modal-lg" id="modal7" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form id="addmentor">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Form Input Data Tentor</h5><button type="button" class="btn btn-label-danger btn-icon"
                    data-bs-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <label class="form-label" for="text">Nama Mentor</label>
                        <input name="nama_mentor" class="form-control nama_mentor" type="text">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="text">Deskripsi</label>
                        <input name="deskripsi" class="form-control deskripsi" type="text">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="text">Jabatan</label>
                        <input name="jabatan" class="form-control jabatan" type="text">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="text">Nama Mentor</label>
                        <input name="name" class="form-control jabatan" type="text">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="text">Username</label>
                        <input name="username" class="form-control jabatan" type="text">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="text">Email</label>
                        <input name="email" class="form-control jabatan" type="email">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="text">password</label>
                        <input name="password" class="form-control jabatan" type="password">
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label" for="text">Foto Mentor</label>
                        <input class="form-control file gambar" id="input-id" name="gambar" type="file"
                            data-preview-file-type="text" required>
                        <p class="text-danger"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn-close"
                    data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-tambah">Simpan</button>
            </div>
        </form>
    </div>
  </div>
</div>
<div class="modal fade" id="modal8" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updatementor">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Form Input Data Tentor</h5><button type="button" class="btn btn-label-danger btn-icon"
                        data-bs-dismiss="modal"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="form-label" for="text">Nama Mentor</label>
                            <input name="nama_mentor1" class="form-control nama_mentor1" type="text">
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label" for="text">Deskripsi</label>
                            <input name="deskripsi1" class="form-control deskripsi1" type="text">
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label" for="text">Jabatan</label>
                            <input name="jabatan1" class="form-control jabatan1" type="text">
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label" for="text">Foto Mentor</label>
                            <input class="form-control file gambar1" id="input-id" name="gambar1" type="file"
                                data-preview-file-type="text" required>
                            <p class="text-danger"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btn-close"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" style="display:none" class="btn btn-primary btn-update">perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal9" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editAktif">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Aktivasi Mentor</h5><button type="button" class="btn btn-label-danger btn-icon"
                        data-bs-dismiss="modal"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12">
                        <label class="form-label">Status Mentor</label>
                        <select name="is_active" class="form-control is_active">
                            <option>Select</option>
                            <option value="1">Active</option>
                            <option value="0">Non Active</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btn-close"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" style="display:none" class="btn btn-primary btn-update-status">perbarui</button>
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
        var url = "{{ asset('public/mentor/') }}"
        var table = $('#yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            "searching": true,
            filter: true,
            ajax: "{{ route('dataTentor') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'text-center'
                },
                {
                    data: 'nama_mentor',
                    name: 'name',
                    className: 'text-center'
                },
                {
                    data: 'jabatan',
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
                    data: 'is_active',
                    name: 'name',
                    className: 'text-center',
                    render : function(meta,data,row){
                        console.log(row);
                        if(row.is_active == 1){
                            return "<span class='badge badge-success'>Aktif</span>"
                        }else{
                            return "<span class='badge badge-danger'>Non Aktif</span>"
                        }
                    }
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
                url: "{{ route('addMentor') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    if (response) {
                        this.reset();
                        // alert('Image has been uploaded successfully');
                        toastr.success('Mentor', 'Sudah Dimasukkan');
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

        let mentor_id = 0;
        $(document).on('click', '.btn-edit', function () {
            params = table.row($(this).closest('tr')).data();
            mentor_id = params.id_mentor;
            $('.nama_mentor1').val(params.nama_mentor);
            $('.deskripsi1').val(params.deskripsi);
            $('.jabatan1').val(params.jabatan);
            $('.btn-tambah').hide()
            $('.btn-update').show()
            $('#modal8').modal('show');

        });

        $(document).on('click', '.btn-update', function () {
            var nama_mentor = $('.nama_mentor1').val();
            var gambar = $('.gambar1').val();
            var deskripsi = $('.deskripsi1').val();
            var jabatan = $('.jabatan1').val();
            $('#modal8').modal('show');
            $.ajax({
                url: "{{ route('updateMentor') }}",
                type: "POST",
                data: {
                    nama_mentor: nama_mentor,
                    deskripsi: deskripsi,
                    jabatan: jabatan,
                    gambar: gambar,
                    id_mentor: mentor_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    $('.nama_kategori').val('')
                    toastr.success('Data kategori ' + 
                        ' berhasil di perbarui', 'Berhasil !!!');
                    table.ajax.reload(null, false)
                    $('#modal8').modal('hide');
                },
                error: function (data) {
                    toastr.error(data.responseJSON.message, 'Error !!!');
                    $('#modal8').modal('hide');
                },
            });
            $('.btn-save').show()
            $('.btn-update').hide()
        });

        let = id = 0
        $(document).on('click', '.btn-active', function () {
            params = table.row($(this).closest('tr')).data();
            id = params.id;
            $('.is_active').val(params.is_active);
            $('.btn-update-status').show()
            $('#modal9').modal('show');

        });

        $(document).on('click', '.btn-update-status', function () {
            var is_active = $('.is_active').val();
            $('#modal9').modal('show');
            $.ajax({
                url: "{{ route('updateStatusMentor') }}",
                type: "POST",
                data: {
                    is_active: is_active,
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    toastr.success('Status Mentor berhasil di perbarui', 'Berhasil !!!');
                    table.ajax.reload(null, false)
                    $('#modal9').modal('hide');
                },
                error: function (data) {
                    toastr.error(data.responseJSON.message, 'Error !!!');
                    $('#modal9').modal('hide');
                },
            });
            $('.btn-update-status').hide()
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
                        $.get(_url + "/deleteMentor/" + params.id_mentor, function (data) {
                            toastr.success('Data kategori ' + params.nama_mentor +
                                ' berhasil di simpan',
                                'Berhasil !!!');
                            table.ajax.reload(null, false)
                        });
                    }
                })
            })

    });

</script>
@endsection
