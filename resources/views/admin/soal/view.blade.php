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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Manajemen Soal

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
                    <div class="col-xl-10">
                        <div class="btn-group">
                            <a class="btn btn-primary"
                                href="{{ route('soal.create', ['id_materi' => isset($_GET['id_materi']) ? $_GET['id_materi'] : '' ]) }}"><i
                                    class="fas fa-plus"></i></a>
                            <a href="" class="btn btn-sm btn-light text-muted"><i
                                    class="fas fa-sync-alt"></i></a>&nbsp;&nbsp;
                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal7"><i
                                    class="fas fa-plus"></i>Excel</a>
                        </div>
                    </div>
                    <div class="col-xl-2">
                        <a class="btn btn-info" href="{{route('downloadTemplateSoal')}}"><i class="fas fa-download"></i>Template Excel</a>

                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 fs-9"
                        id="yajra-datatable">
                        <div id="datatable-buttons_wrapper"></div>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Deskripsi Soal</th> 
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
<div class="modal fade " id="modal7" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addkategori">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Masukkan Excel</h5><button type="button"
                        class="btn btn-label-danger btn-icon" data-bs-dismiss="modal"><i
                            class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="file"
                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
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

</script>
<script>
    function renderForm(i = null) {
        if (i == null) {
            document.getElementById("addmentor").reset();
            $('#addmentor').find('.id_paket').remove();
            $(".input-file").fileinput('destroy');
            $(".input-file").fileinput({
                'showUpload': false,
                'previewFileType': 'any',
            });
        } else {
            $('#addmentor').append(`<input type="hidden" class="id_paket" name="id_paket" value="${i.id_paket}" />`);
            $(".input-file").fileinput('destroy');
            $(".input-file").fileinput({
                'showUpload': false,
                'previewFileType': 'any',
                initialPreview: [
                    "<img src='" + i.url_gambar +
                    "' class='file-preview-image' alt='Desert' title='Desert'>"
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
            ajax: {
                url: "{{ route('soal.view') }}",
                data: function (d) {
                    d.id_materi  = "{{ isset($_GET['id_materi']) ? $_GET['id_materi'] : '' }}"
                    return d;
                }

            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'text-center'
                }, 
                {
                    data: 'pertanyaan',
                    name: 'name',
                    className: 'text-left',
                    render: function (meta, data, row) {
                        if (row.pertanyaan.length > 100) {
                            return row.pertanyaan.substring(0, 100) + '...';
                        }
                        return row.pertanyaan;
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

            $.ajax({
                type: 'POST',
                url: "{{ route('addPaket') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    if (response) {
                        this.reset();
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
            if (params.gambar != null) {
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
