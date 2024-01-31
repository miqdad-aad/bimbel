@extends('admin.layout')
@section('content')
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
                                <th>Kode Kategori Soal</th>
                                <th>Nama Kategori Soal</th>
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
            <form id="addmentor">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Form Input Kategori Soal</h5><button type="button" class="btn btn-label-danger btn-icon"
                        data-bs-dismiss="modal"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="form-label" for="text">Nama Kategori Soal</label>
                            <input name="nama_mentor" class="form-control nama_mentor" type="text">
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
            ajax: "{{ route('masterKategoriSoal') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'text-center'
                },
                {
                    data: 'kode_kategori_soal',
                    name: 'name',
                    className: 'text-center'
                },
                {
                    data: 'uraian_kategori_soal',
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
                url: "{{ route('postKategoriSoal') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    if (response) {
                        this.reset();
                        // alert('Image has been uploaded successfully');
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
        let kategori_id = 0;
        $(document).on('click', '.btn-edit', function () {
            params = table.row($(this).closest('tr')).data();
            kategori_id = params.id_kategori_soal;
            console.log(kategori_id);
            $('.nama_mentor').val(params.uraian_kategori_soal);
            $('.btn-tambah').hide()
            $('.btn-update').show()
            $('#modal7').modal('show');

        });
        $(document).on('click', '.btn-update', function () {
            var kategori = $('.nama_mentor').val();
            $('#modal7').modal('show');
            $.ajax({
                url: "{{ route('updateKategoriSoal') }}",
                type: "POST",
                data: {
                    kategori: kategori,
                    id_kategori: kategori_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    $('.nama_mentor').val('')
                    toastr.success('Data kategori ' + 
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
