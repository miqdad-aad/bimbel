@extends('admin.layout')
@section('content')
<style>
    .select2-selection__rendered{
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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{ isset($data) ? 'Edit ' : 'Tambah ' }} Materi

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
                        <div class="col-sm-12 form-group">
                            <label for=""><p><h3>Judul Materi</h3></p></label>
                            <input type="text" name="judul_materi" class="form-control" value="{{ isset($data->judul_materi) ? $data->judul_materi : '' }}">
                        </div>
                        <div class="col-sm-12 form-group">
                            <label for=""><p><h3>Uraian Materi</h3></p></label>
                            <textarea name="uraian_materi"  cols="30" class="form-control" rows="10">{{ isset($data->uraian_materi) ? $data->uraian_materi : '' }}</textarea>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for=""><p><h3>File tambahan</h3></p></label>
                            <input type="file" name="file_tambahan_soal" class="form-control input-file">
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for=""><p><h3>Kategori Soal</h3></p></label>
                                    <select class="select2class form-control" name="id_soal">
                                        @foreach($paket as $h)
                                            <option <?= isset($data->id_kategori_soal) && $data->id_kategori_soal == $h->id_kategori_soal ?'selected' : '' ?> value="{{ $h->id_kategori_soal }}">{{ $h->uraian_kategori_soal }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for=""><p><h3>Kategori Materi</h3></p></label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" <?= isset($data) && $data->typeMateri == 'tryout' ? 'checked' : '' ?> checked name="typeMateri" id="inlineRadio1" value="tryout">
                                        <label class="form-check-label" for="inlineRadio1">Try Out</label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" <?= isset($data) && $data->typeMateri == 'umum' ? 'checked' : '' ?> name="typeMateri" id="inlineRadio2" value="umum">
                                        <label class="form-check-label" for="inlineRadio2">Umum</label>
                                      </div> 
                                </div>
                                <div class="col-sm-12 form-group umum-sec <?= isset($data) && $data->typeMateri == 'umum' ? '' : ' d-none' ?> ">
                                    <label for=""><p><h3>Link Materi</h3></p></label>
                                    <input name="link_materi"  value="{{ isset($data->link_materi) ? $data->link_materi : '' }}" class="form-control" >
                                </div>
                                <div class="col-sm-12 form-group umum-sec <?= isset($data) && $data->typeMateri == 'umum' ? '' : ' d-none' ?> ">
                                    <label for=""><p><h3>Link Video</h3></p></label>
                                    <input name="link_video"  value="{{ isset($data->link_video) ? $data->link_video : '' }}" class="form-control" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
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
    $(document).ready(function() {
        $('#summernote').summernote();
        
        $('.select2class').select2({});
        $('input[type=radio][name=typeMateri]').change(function() {
            $('.umum-sec').addClass('d-none');
            if($(this).val() == 'umum') $('.umum-sec').removeClass('d-none'); 
        })
        
       @if (isset($data) && $data->gambar)
            let url_gambar = "{{ asset('public/pembelajaran/'.$data->gambar) }}"
            $(".input-file").fileinput({
                'showUpload': false,
                'previewFileType': 'any',
                initialPreview: [
                    "<img src='"+ url_gambar +"' class='file-preview-image' alt='Desert' title='Desert'>"
                ]
            });
        @else
            $(".input-file").fileinput({
                'showUpload': false,
                'previewFileType': 'any',
            });

       @endif

    });

   
</script>

@endsection
