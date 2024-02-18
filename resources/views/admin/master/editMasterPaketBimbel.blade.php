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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Tambah Soal

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
            <form action="{{ route('updatePaketBimbel') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" hidden name="id_paket_bimbel" value="{{ $data->id_paket_bimbel }}">
                <div class="card-body py-3">
                    <div class="row form-group">
                        <div class="col-sm-12 form-group">
                            <label for="">
                                <p>
                                    <h3>Nama Paket Bimbel</h3>
                                </p>
                            </label>
                            <input type="text" name="nama_paket" class="form-control"
                                value="{{ $data->nama_paket_bimbel }}">
                        </div>
                        <div class="col-sm-12 form-group">
                            <label for="">
                                <p>
                                    <h3>Deskripsi Paket</h3>
                                </p>
                            </label>
                            <textarea name="deskripsi_paket" cols="10" class="form-control"
                                rows="10">{{ $data->deskripsi_paket }}</textarea>
                        </div>
                        <div class="col-sm-3 form-group">
                            <label for="">
                                <p>
                                    <h3>Harga</h3>
                                </p>
                            </label>
                            <input type="number" name="harga" class="form-control"
                                value="{{ $data->harga_paket_bimbel }}">
                        </div>
                        <div class="col-sm-3 form-group">
                            <label for="">
                                <p>
                                    <h3>Kuota Peserta</h3>
                                </p>
                            </label>
                            <input type="number" name="kuota" class="form-control" value="{{ $data->kuota_peserta }}">
                        </div>
                        <div class="col-sm-3 form-group">
                            <label for="">
                                <p>
                                    <h3>Tanggal Mulai</h3>
                                </p>
                            </label>
                            <input type="date" name="tanggal_mulai" class="form-control">
                        </div>
                        <div class="col-sm-3 form-group">
                            <label for="">
                                <p>
                                    <h3>Tanggal Selesai</h3>
                                </p>
                            </label>
                            <input type="date" name="tanggal_selesai" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-12 form-group">
                            <hr>
                            <h3>Materi Yang di dapat</h3>
                        </div>
                        <div class="col-sm-12 form-group">
                            <table class="table table-sm table-bordered" width="100%">
                                <thead>
                                    <tr class="text-center">
                                        <th>Nama Materi</th>
                                        <th>
                                            <button class="btn btn-sm btn-success add-jawaban" type="button"><i
                                                    class="fa fa-plus-circle"></i></button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="body-jawaban">
                                    @foreach($detail as $t)
                                    <tr class="text-center">
                                        <td class="text-center"><select class="select2class form-control" name="id_kategori_soal[]">
                                            <option value="{{ $t->id_materi }}">{{ $t->judul_materi }}</option>
                                            @foreach($kategori as $h)
                                                <option value="{{ $h->id_materi }}">{{ $h->judul_materi }}</option>
                                            @endforeach
                                        </select></td>
                                        </td>
                                        <td><button class="btn btn-sm btn-danger" type="button"><i
                                                    class="fa fa-trash"></i></button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button class="btn btn-success">Simpan Soal</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('page-js')
<script>
    $(document).ready(function () {
        $('#summernote').summernote();
        $('.select2class').select2({});

        $(document).on('click', '.add-jawaban', function () {
            $('.body-jawaban').append(`<tr class="text-center">
                <td class="text-center"><select class="select2class form-control" name="id_kategori_soal[]">
                                @foreach($kategori as $h)
                                    <option value="{{ $h->id_materi }}">{{ $h->judul_materi }}</option>
                                @endforeach
                            </select></td>
                <td><button class="btn btn-sm btn-danger" type="button"><i class="fa fa-trash"></i></button></td>
            </tr>`);

            generateCodeJawaban()
        });

        $(".input-file").fileinput({
            'showUpload': false,
            'previewFileType': 'any',
        });
    });

    function generateCodeJawaban() {
        let i = 0;
        let alphabetArray = [];

        for (let i = 65; i <= 90; i++) {
            alphabetArray.push(String.fromCharCode(i));
        }

        $('.body-jawaban').find('tr').each(function () {
            var kode = alphabetArray[i];
            $(this).find('.kode-jawaban').val(kode);
            i++;
        })
    }

</script>

@endsection
