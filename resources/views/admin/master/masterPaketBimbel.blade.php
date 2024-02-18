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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Tambah Paket

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
                            <a href="{{ route('addPaketBimbel') }}" class="btn btn-primary" ><i class="fas fa-plus"></i></a>
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
                                <th>Nama Paket</th>
                                <th>Harga</th>
                                <th>Kuota</th>
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
                    <h5 class="modal-title">Form Input Data Paket</h5><button type="button" class="btn btn-label-danger btn-icon"
                        data-bs-dismiss="modal"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="form-label" for="text">Nama Paket</label>
                            <input name="nama_paket" class="form-control nama_paket" type="text">
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label" for="text">Harga</label>
                            <input name="harga" class="form-control input-mask harga" data-inputmask="'alias': 'currency', 'prefix': '', 'digits': '2'" type="text">
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label" for="text">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control deskripsi" type="text"></textarea>
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label" for="text">Foto</label>
                            <input class="form-control input-file"  name="gambar" type="file" >
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
@endsection
@section('page-js')
<script>
    
    </script>
<script>
    function renderForm(i = null){
        if(i == null){
            document.getElementById("addmentor").reset();
            $('#addmentor').find('.id_paket').remove();
            $(".input-file").fileinput('destroy');
            $(".input-file").fileinput({
                'showUpload': false,
                'previewFileType': 'any',
            });
        }else{
            $('#addmentor').append(`<input type="hidden" class="id_paket" name="id_paket" value="${i.id_paket}" />`);
            $(".input-file").fileinput('destroy');
            $(".input-file").fileinput({
                'showUpload': false,
                'previewFileType': 'any',
                initialPreview: [
                    "<img src='"+ i.url_gambar +"' class='file-preview-image' alt='Desert' title='Desert'>"
                ]
            });
        }
    }
    $(document).ready(function () {

        var _url = $('meta[name="url"]').attr('content');
        var params = null;
        var table = $('#yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            "searching": true,
            filter: true,
            ajax: "{{ route('paketBimbel') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'text-center'
                },
                {
                    data: 'nama_paket_bimbel',
                    name: 'name',
                    className: 'text-center'
                },
                {
                    data: 'harga_paket_bimbel',
                    name: 'name',
                    className: 'text-center',
                },
                {
                    data: 'kuota_peserta',
                    name: 'name',
                    className: 'text-right',
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

            $.ajax({
                type: 'POST',
                url: "{{ route('addPaket') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    if (response) {
                        this.reset();
                        toastr.success('Paket', 'Sudah Dimasukkan');
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

        let id_paket = 0;
        $(document).on('click', '.btn-edit', function () {
            params = table.row($(this).closest('tr')).data();
            id_paket = params.id_mentor;
            $('.nama_paket').val(params.nama_paket);
            $('.deskripsi').val(params.deskripsi);
            $('.harga').val(params.harga);
            if(params.gambar != null){
                renderForm(params)
            }
            $('#modal7').modal('show');
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
                        $.get(_url + "/deleteKegiatan/" + params.id_kegiatan, function (data) {
                            toastr.success('Data Kegiatan ' + params.nama_kegiatan +
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
