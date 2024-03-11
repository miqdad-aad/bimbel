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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Manajemen Akun

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
                                <th>Nama</th>
                                <th>Username Akun</th>
                                <th>Email</th>
                                <th>Is Active</th>
                                <th>Role</th>
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
@endsection
@section('page-js')
<script>
    $(document).ready(function () {

        var _url = $('meta[name="url"]').attr('content');
        var params = null;

        var table = $('#yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            filter: true,
            ajax: "{{ url('/listAkun') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'text-center'
                },
                {
                    data: 'name',
                    name: 'name',
                    className: 'text-center'
                },
                {
                    data: 'username',
                    name: 'name',
                    className: 'text-center'
                },
                {
                    data: 'email',
                    name: 'name',
                    className: 'text-center'
                },
                {
                    data: 'is_active',
                    name: 'name',
                    className: 'text-center',
                    render : function(meta,data,row){
                        if(row.is_active == '1'){
                            return '<span class="badge bg-success"> Aktif</span>';
                        }else{
                            return '<span class="badge bg-danger"> Non Aktif</span>';
                        }
                     }
                },
                {
                    data: 'role',
                    name: 'name',
                    className: 'text-center',
                    render : function(meta,data,row){
                        if(row.role == '1'){
                            return '<span class="badge bg-info"> Admin</span>';
                        }else if(row.role == '2'){
                            return '<span class="badge bg-info"> Mentor</span>';
                        }else{
                            return '<span class="badge bg-info"> Siswa</span>';
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

        $('#addkategori').submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('#image-input-error').text('');

            $.ajax({
                type: 'POST',
                url: "{{ route('addBabTes') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    if (response) {
                        this.reset();
                        // alert('Image has been uploaded successfully');
                        toastr.success('Bab Tes', 'Sudah Dimasukkan');
                        $('#modal7').modal('hide');
                        table.ajax.reload(null, false);
                    }
                },
                error: function (response) {
                    console.log(response);
                    toastr.error('Bab Tes', 'Error');
                    $('#image-input-error').text(response.responseJSON.errors.file);
                }
            });
        });

        let bab_tes_id = 0;
        $(document).on('click', '.btn-edit', function () {
            params = table.row($(this).closest('tr')).data();
            bab_tes_id = params.id_bab_tes;
            $('.nama_bab').val(params.bab);
            $('.id_bab_tes').val(params.id_bab_tes);
            $('.id_materi_tes').val(params.id_materi_tes);
            $('.btn-tambah').hide()
            $('.btn-update').show()
            $('#modal7').modal('show');

        });
        $(document).on('click', '.btn-update', function () {
            var bab = $('.nama_bab').val();
            var id_materi_tes = $('.id_materi_tes').val();
            console.log(id_materi_tes);
            var bab_tes_id = $('.id_bab_tes').val();
            $('#modal7').modal('show');
            $.ajax({
                url: "{{ route('updateBabTes') }}",
                type: "POST",
                data: {
                    bab: bab,
                    id_materi_tes: id_materi_tes,
                    bab_tes_id: bab_tes_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    $('.jenis_tes').val('')
                    toastr.success('Data Bab Tes ' + 
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
