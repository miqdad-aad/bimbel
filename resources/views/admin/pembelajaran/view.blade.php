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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Tambah Pembelajaran

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
                    <div class="col-sm-2 form-group">
                        <label class="form-group" style="margin-bottom:5px;" for="">Action</label><br>
                        <div class="btn-group">
                            <a class="btn btn-primary btn-sm" href="{{ route('pembelajaran.create') }}"><i
                                    class="fas fa-plus"></i></a>
                            <a href="" class="btn btn-sm btn-light text-muted"><i
                                    class="fas fa-sync-alt"></i></a>&nbsp;&nbsp;
                        </div>
                    </div>
                    <div class="col-sm-3 form-group">
                        <label class="form-group" style="margin-bottom:5px;">Jenis Tes</label>
                        <select class="id_jenis_tes form-control form-control-sm filter"></select>
                    </div>
                    <div class="col-sm-3 form-group">
                        <label class="form-group" style="margin-bottom:5px;">Kategori Pembelajaran</label>
                        <select class="kategori_pembelajaran form-control form-control-sm filter">
                            <option value="">Tampilkan Semua</option>
                            @foreach($kategoriPembelajaran as $h)
                                <option value="{{ $h->id_kategori_pembelajaran }}">{{ $h->nama_kategori_pembelajaran }}</option>
                            @endforeach
                        </select>
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
                                <th>Judul Pembelajaran</th>
                                <th>Kategori Pembelajaran</th>
                                <th>Uraian Pembelajaran</th>
                                <th>Total Soal</th>
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
        var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
        

        var _url = $('meta[name="url"]').attr('content');
        var params = null;
        var table = $('#yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            "searching": true,
            filter: true,
            ajax: {
                url: "{{ route('pembelajaran.view.ajax') }}",
                type: "POST",
                data: function(data){
                    data.id_jenis_tes = $('.id_jenis_tes').val();
                    data.kategori_pembelajaran = $('.kategori_pembelajaran') .val(); 
                    return data;
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'text-center'
                },
                {
                    data: 'jenis_tes.jenis_tes',
                    name: 'name',
                    className: 'text-left'
                },
                {
                    data: 'judul_materi',
                    name: 'name',
                    className: 'text-left'
                },
                {
                    data: 'kategori_pembelajaran.nama_kategori_pembelajaran',
                    name: 'name',
                    className: 'text-left'
                },
                {
                    data: 'uraian_materi',
                    name: 'name',
                    className: 'text-left',
                    render: function (meta, data, row) {
                        if (row.uraian_materi.length > 100) {
                            return row.uraian_materi.substring(0, 100) + '...';
                        }
                        return row.uraian_materi;
                    }
                },

                {
                    data: 'totalSoal',
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


    $(document).on('change', '.filter', function(){
        table.ajax.reload();
    })

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

 
    $(".id_jenis_tes").select2({
        placeholder: 'Pilih Jenis Materi',
        allowClear: true,
        minimumInputLength: 0,
        ajax: {
            url: "{{ route('getJenisTes') }}",
            dataType: 'json',
            type: "post",
            processResults: function (data) {
                return {
                    results: data.map(function (item) {
                        item.id = item.id_jenis_tes;
                        item.text = item.jenis_tes;
                        return item;
                    })
                };
            }
        }
    }).on('select2:select', function (e) {
        
    });


</script>
@endsection
