@extends('admin.layout')
@section('content')
<style>
    .select2-selection__rendered {
        margin-top: -6px !important;
    }

</style>
<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{ isset($data) ? 'Edit ' : 'Tambah ' }}
                Pembelajaran

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
            <form action="{{ route('addpembelajaran.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @if (isset($data))
                <input type="hidden" name="id_materi" value="{{ $data->id_materi }}">
                @endif
                <div class="card-body py-3">
                    <div class="row form-group">
                        <div class="col-sm-4 form-group">
                            <label for="">
                                <p>
                                    <h3>Jenis Tes</h3>
                                </p>
                            </label>
                            <select class="form-control form-control-sm //form-control-solid id_jenis_tes"
                                name="materi">

                            </select>
                        </div>
                        <div class="col-sm-4 form-group">
                            <label for="">
                                <p>
                                    <h3>Materi Tes</h3>
                                </p>
                            </label>
                            <select class="form-control form-control-sm //form-control-solid id_materi" name="materi">

                            </select>
                        </div>
                        <div class="col-sm-4 form-group">
                            <label for="">
                                <p>
                                    <h3>Bab Tes</h3>
                                </p>
                            </label>
                            <select class="form-control form-control-sm //form-control-solid id_bab" name="bab">

                            </select>
                        </div>
                        <div class="col-sm-12 form-group">
                            <label for="">
                                <p>
                                    <h3>Judul Pembelajaran</h3>
                                </p>
                            </label>
                            <input type="text" name="judul_materi" class="form-control"
                                value="{{ isset($data->judul_materi) ? $data->judul_materi : '' }}">
                        </div>
                        <div class="col-sm-12 form-group">
                            <label for="">
                                <p>
                                    <h3>Uraian Pembelajaran</h3>
                                </p>
                            </label>
                            <textarea name="uraian_materi" cols="30" class="form-control"
                                rows="10">{{ isset($data->uraian_materi) ? $data->uraian_materi : '' }}</textarea>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="">
                                <p>
                                    <h3>File tambahan</h3>
                                </p>
                            </label>
                            <input type="file" name="file_tambahan_soal" class="form-control input-file">
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="">
                                        <p>
                                            <h3>Kategori Soal</h3>
                                        </p>
                                    </label>
                                    <select class="select2class form-control" name="id_soal">
                                        @foreach($paket as $h)
                                        <option
                                            <?= isset($data->id_kategori_soal) && $data->id_kategori_soal == $h->id_kategori_soal ?'selected' : '' ?>
                                            value="{{ $h->id_kategori_soal }}">{{ $h->uraian_kategori_soal }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="">
                                        <p>
                                            <h3>Nama Mentor</h3>
                                        </p>
                                    </label>
                                    <select class="select2class form-control" name="id_mentor">
                                        @foreach($mentor as $m)
                                        <option <?= isset($data->id) && $data->id == $m->id ?'selected' : '' ?>
                                            value="{{ $m->id }}">{{ $m->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="">
                                        <p>
                                            <h3>Kategori Pembelajaran</h3>
                                        </p>
                                    </label><br>
                                    <select class="select2class form-control" name="id_kategori_pembelajaran">
                                        @foreach($kategoriPembelajaran as $h)
                                        <option
                                            <?= isset($data->id_kategori_pembelajaran) && $data->id_kategori_pembelajaran == $h->id_kategori_pembelajaran ?'selected' : '' ?>
                                            value="{{ $h->id_kategori_pembelajaran }}">
                                            {{ $h->nama_kategori_pembelajaran }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-12 form-group umum-sec ">
                                    <label for="">
                                        <p>
                                            <h3>Link Materi</h3>
                                        </p>
                                    </label>
                                    <input name="link_materi"
                                        value="{{ isset($data->link_materi) ? $data->link_materi : '' }}"
                                        class="form-control">
                                </div>
                                <div class="col-sm-12 form-group umum-sec ">
                                    <label for="">
                                        <p>
                                            <h3>Link Video</h3>
                                        </p>
                                    </label>
                                    <input name="link_video"
                                        value="{{ isset($data->link_video) ? $data->link_video : '' }}"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-sm-12">
                            <hr>
                            <button class="btn btn-success">Simpan Materi</button>
                            <a href="{{ route('pembelajaran.view') }}" class="btn btn-danger">Kembali</a>
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
        $('input[type=radio][name=typeMateri]').change(function () {
            $('.umum-sec').addClass('d-none');
            if ($(this).val() == 'umum') $('.umum-sec').removeClass('d-none');
        })

        @if(isset($data) && $data->gambar)
        let url_gambar = "{{ asset('public/pembelajaran/'.$data->gambar) }}"
        $(".input-file").fileinput({
            'showUpload': false,
            'previewFileType': 'any',
            initialPreview: [
                "<img src='" + url_gambar +
                "' class='file-preview-image' alt='Desert' title='Desert'>"
            ]
        });
        @else
        $(".input-file").fileinput({
            'showUpload': false,
            'previewFileType': 'any',
        });

        @endif

        $('.select2').select2({})
        let jenis_tes_id = 1;

        var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
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
                            item.id = item.id_m_jenis_tes;
                            item.text = item.jenis_tes;
                            return item;
                        })
                    };
                }
            }
        }).on('select2:select', function (e) {
            $('.id_materi').val(null).trigger('change')
        });

        $('.id_materi').select2({
            placeholder: 'Pilih Materi',
            allowClear: true,
            width: 'resolve',
            minimumInputLength: 0,
            ajax: {
                dataType: "json",
                method: 'POST',
                url: "{{route('getMateriTes')}}",
                data: function (d) {
                    console.log(d);
                    d.id = $('.id_jenis_tes').val()
                    return d;
                },
                processResults: function (data) {
                    return {
                        results: data.map(function (item) {
                            item.id = item.id_m_materi_tes;
                            item.text = item.nama_materi_tes;
                            return item;
                        })
                    };
                },
            },
            escapeMarkup: function (m) {
                return m;
            }
        }).on('select2:select', function (e) {
            $('.id_bab').val(null).trigger('change')
        });

        $('.id_bab').select2({
            placeholder: 'Pilih Bab',
            allowClear: true,
            width: 'resolve',
            minimumInputLength: 0,
            ajax: {
                dataType: "json",
                method: 'POST',
                url: "{{route('getBabTes')}}",
                data: function (d) {
                    console.log(d);
                    d.id = $('.id_materi').val()
                    return d;
                },
                processResults: function (data) {
                    return {
                        results: data.map(function (item) {
                            item.id = item.id_m_bab_tes;
                            item.text = item.bab;
                            return item;
                        })
                    };
                },
            },
            escapeMarkup: function (m) {
                return m;
            }
        });
    });

</script>

@endsection
