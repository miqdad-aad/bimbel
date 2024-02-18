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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Edit Soal

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
            <form action="{{ route('soal.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" value="{{ $soal->id_soal }}" name="id_soal" hidden>
                <div class="card-body py-3">
                    <div class="row form-group">
                        <div class="col-sm-12 form-group">
                            <label for=""><p><h3>Uraian Soal</h3></p></label>
                            <textarea name="pertanyaan"  cols="30" class="form-control" rows="10">{{ $soal->pertanyaan }}</textarea>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for=""><p><h3>File tambahan</h3></p></label>
                            <input type="file" name="file_tambahan_soal" class="form-control input-file">
                        </div>
                        <div class="col-sm-3 form-group">
                            <label for=""><p><h3>Score</h3></p></label>
                            <input type="number" name="score" class="form-control" value="{{ $soal->score }}">
                        </div>
                        <div class="col-sm-3 form-group">
                            <label for=""><p><h3>Paket</h3></p></label>
                            <select class="select2class" name="id_paket">
                                @foreach($paket as $h)
                                    <option <?= $h->id_paket == $soal->id_paket ?> value="{{ $h->id_paket }}">{{ $h->nama_paket }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-12 form-group">
                            <hr>
                            <h3>Jawaban</h3>
                        </div>
                        <div class="col-sm-12 form-group">
                            <table class="table table-sm table-bordered" width="100%">
                                <thead>
                                    <tr class="text-center">
                                        <th>Kode</th>
                                        <th>Benar ?</th>
                                        <th>Uraian Jawaban</th>
                                        <th>File tambahan</th>
                                        <th>

                                            <button class="btn btn-sm btn-success add-jawaban" type="button"><i class="fa fa-plus-circle"></i></button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="body-jawaban">
                                    @foreach($jawab as $t)
                                    <tr class="text-center">
                                        <td style="width:50px;" class="text-center"><input name="kode_jawaban[]" value="{{ $t->kode_jawaban }}" class="form-control form-control-sm kode-jawaban" /></td>
                                        <td class="text-center"><input type="radio" name="is_true[]" <?= $t->is_true == 1 ? 'checked' : '' ?> /></td>
                                        <td style="width:50%"> <textarea name="keterangan[]"  cols="30" class="form-control summernote-jawaban" rows="2">{{ $t->keterangan }}</textarea></td>
                                        <td>
                                            <input type="file"  name="file_tambahan[]" class="form-control form-control-sm" />
                                            @if(!empty($t->file_tambahan))
                                            <a href="{{ asset('public/jawaban/'. $t->file_tambahan) }}" download>Download File</a>
                                            @endif
                                        </td>
                                        <td><button class="btn btn-sm btn-danger" type="button"><i class="fa fa-trash"></i></button></td>
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
    $(document).ready(function() {
        $(".input-file").fileinput({
                'showUpload': false,
                'previewFileType': 'any',
                initialPreview: [
                    "<img src='<?= asset('public/soal/'. $soal->file_tambahan) ?>' class='file-preview-image' alt='Desert' title='Desert'>"
                ]
            });
        $('#summernote').summernote();
        $('.select2class').select2({});
        
        $(document).on('click','.add-jawaban', function(){
            $('.body-jawaban').append(
            `<tr class="text-center">
                <td style="width:50px;" class="text-center"><input name="kode_jawaban[]" class="form-control form-control-sm kode-jawaban" /></td>
                <td class="text-center"><input type="radio" name="is_true[]" /></td>
                <td style="width:50%"> <textarea name="keterangan[]"  cols="30" class="form-control summernote-jawaban" rows="2"></textarea></td>
                <td><input type="file"  name="file_tambahan[]" class="form-control form-control-sm" /></td>
                <td><button class="btn btn-sm btn-danger" type="button"><i class="fa fa-trash"></i></button></td>
            </tr>`);

            generateCodeJawaban()
        })
    });

    function generateCodeJawaban(){
        let i = 0;
        let alphabetArray = [];

        for (let i = 65; i <= 90; i++) {
            alphabetArray.push(String.fromCharCode(i));
        }

        $('.body-jawaban').find('tr').each(function(){
            var kode = alphabetArray[i];
            $(this).find('.kode-jawaban').val(kode);
            i++;
        })
    }
</script>

@endsection
