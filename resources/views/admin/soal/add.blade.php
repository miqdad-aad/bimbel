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
            <div class="card-body py-3">
                <div class="row form-group">
                    <div class="col-sm-12 form-group">
                        <label for=""><p><h3>Uraian Soal</h3></p></label>
                        <textarea name=""  cols="30" class="form-control" rows="10"></textarea>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for=""><p><h3>File tambahan</h3></p></label>
                        <input type="file" class="form-control">
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for=""><p><h3>Score</h3></p></label>
                        <input type="number" class="form-control">
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-js')
<script>
    $(document).ready(function() {
        $('#summernote').summernote();
        
        $(document).on('click','.add-jawaban', function(){
            $('.body-jawaban').append(`<tr class="text-center">
                <td style="width:50px;" class="text-center"><input class="form-control form-control-sm kode-jawaban" /></td>
                <td class="text-center"><input type="radio" /></td>
                <td style="width:50%"> <textarea name=""  cols="30" class="form-control summernote-jawaban" rows="2"></textarea></td>
                <td><input type="file" class="form-control form-control-sm" /></td>
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
