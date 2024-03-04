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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Manajemen Booking

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
                                <th>Kode Booking</th>
                                <th>Nama</th>
                                <th>Asal Sekolah</th>
                                <th>Paket</th>
                                <th>Jenis Pembayaran</th>
                                <th>Status Pembayaran</th>
                                <th>Status Approve</th>
                                <th>Tanggal Booking</th>
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
                    <h5 class="modal-title">Status Pembayaran</h5><button type="button" class="btn btn-label-danger btn-icon"
                        data-bs-dismiss="modal"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="text" hidden class="id_booking" name="id_booking" id="id_booking">
                        <div class="col-sm-12 id-100">
                            <label class="form-label" for="text">Status Pembayaran</label>
                            <select name="status_pembayaran" id="status_pembayaran" class="form-control ip status_pembayaran">
                                <option value="SUKSES">Sukses</option>
                                <option value="PENDING">Pending</option>
                                <option value="GAGAL">Gagal</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " id="btn-close"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" style="display:none" class="btn btn-primary btn-update">Update Status</button>
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
            ajax: "{{ route('booking.view') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'text-center'
                },
                {
                    data: 'kode_booking',
                    name: 'name',
                    className: 'text-center'
                },
                {
                    data: 'siswa_booking.nama',
                    name: 'name',
                    className: 'text-center'
                },
                {
                    data: 'siswa_booking.asal_sekolah',
                    name: 'name',
                    className: 'text-center'
                },
                {
                    data: 'paket_booking.nama_paket_bimbel',
                    name: 'name',
                    className: 'text-center'
                },
                {
                    data: 'jenis_pembayaran',
                    name: 'name',
                    className: 'text-center'
                },
                {
                    data: 'status_pembayaran',
                    name: 'name',
                    className: 'text-center'
                },
                {
                    data: 'status_approve',
                    name: 'name',
                    className: 'text-center'
                },
                {
                    data: 'created_at',
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

        let booking_id = 0;
        $(document).on('click', '.btn-edit-status', function () {
            params = table.row($(this).closest('tr')).data();
            booking_id = params.id_bab_tes;
            $('.approve').val(params.status_pembayaran);
            $('.id_booking').val(params.id);
            $('.btn-tambah').hide()
            $('.btn-update').show()
            $('#modal7').modal('show');

        });
        $(document).on('click', '.btn-update', function () {
            var status_pembayaran = $('.status_pembayaran').val();
            var booking_id = $('.id_booking').val();
            $('#modal7').modal('show');
            $.ajax({
                url: "{{ route('booking.update') }}",
                type: "POST",
                data: {
                    status_pembayaran: status_pembayaran,
                    booking_id: booking_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    $('.jenis_tes').val('')
                    toastr.success('Proses Data ' + 
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
        $(document).on('click', '.btn-approve', function () {
            var booking_id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('booking.flagApprove') }}",
                type: "POST",
                data: {
                    approve: $(this).attr('status-approve'),
                    booking_id: booking_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                  
                    toastr.success('Proses Data ' + 
                        ' berhasil di perbarui', 'Berhasil !!!');
                    table.ajax.reload(null, false)
                  
                },
                error: function (data) {
                    toastr.error(data.responseJSON.message, 'Error !!!');
                  
                },
            }); 
        });

    });

</script>
@endsection
