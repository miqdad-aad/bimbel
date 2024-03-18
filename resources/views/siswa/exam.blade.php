@extends('admin.layout')
@section('content')
<div class="row gy-5 g-xl-8">
    <div class="col-xl-12">
        <div class="card card-xl-stretch mb-5 mb-xl-8">
            <div class="card-body py-3" id="app">
                <div class="row">
                  
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 form-group">
                        <div class="card">
                            <div v-if="count_soal <= <?= $soal->total_soal - $soal->total_soal_dikerjakan ?>">
                                <div class="card-header">
                                    <h3>Soal {{ $soal->jenis_tes }}</h3>
                                </div>

                                <div class="card-body text-center" v-for="(soal , index) in dataSoal" :key="index">
                                    <h2 class="card-text elment-soal">@{{ soal.pertanyaan }}</h2>
                                    <img :src="soal.url_path_soal_gambar" style="width:40%; margin-bottom:50px;" alt="" v-if="soal.url_path_soal_gambar">

                                    <div class="row elm-jawab">
                                        <div class="col-sm-6 form-group"
                                            v-for="(jawaban , indexJawab) in soal.jawaban_soal" :key="indexJawab" >
                                            <button :disabled="isDisabled" :class="{
                                                'btn btn-answer btn-success': kode_pilih == jawaban.kode_jawaban,
                                                'btn btn-answer btn-danger':  kode_salah == jawaban.kode_jawaban ,
                                                'btn btn-answer btn-secondary' : kode_non_selected == null
                                                }" :keyindex="soal.id_soal" :keyjenistes="soal.id_jenis_tes" :keykode="jawaban.kode_jawaban"
                                                @click="actionRespon">
                                                    <img :keyindex="soal.id_soal" :keyjenistes="soal.id_jenis_tes" :keykode="jawaban.kode_jawaban" :src="jawaban.url_file_tambahan" style="width:40%; margin-bottom:50px;" alt="" v-if="jawaban.url_file_tambahan">
                                                    <span :keyindex="soal.id_soal" :keyjenistes="soal.id_jenis_tes" :keykode="jawaban.kode_jawaban" v-if="!jawaban.url_file_tambahan">@{{ jawaban.kode_jawaban }} - @{{ jawaban.keterangan }}</span>
                                                    
                                                    
                                                </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p class="notifikasi-text-answer">@{{ notifTextAnswer }} </p>
                                            <h4>Total Score @{{ score }}</h4>
                                            <h4>Total Soal  {{ $soal->total_soal }}</h4>
                                            <h4>Total Soal Sudah dikerjakan  @{{ selesai_dikerjakan }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <div class="card-body text-center">
                                    <h2 class="card-text elment-soal">Latihan Soal selesai dengan Score Akhir :
                                        @{{ score }}</h2>
                                    <br>
                                    <br>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<style>
  .btn-answer {
    margin-bottom: 10px;
    width: 100%;
  }

  .elment-soal {
    font-size: 35px;
    font-family: 'Font Awesome 5 Brands';
    margin: 50px 10px 50px 10px;
  }

  .elm-jawab {
    padding-left: 10%;
    padding-right: 10%;
    margin-bottom: 5%;
  }

  .elm-title {
    margin-bottom: 40px;

  }
</style>
@endsection
@section('page-js')

<script>
    var app = new Vue({
        el: '#app',
        data() {
            return {
                items: [{
                        text: 'Beranda',
                        href: '/'
                    },
                    {
                        text: 'Coba Gratis',
                        active: true
                    }
                ],
                dataSoal: null,
                kode_pilih: null,
                isDisabled: false,
                kode_salah: null,
                kode_non_selected: null,
                notifTextAnswer: '',
                score: parseFloat("{{ $soal->score }}"),
                count_soal: 0,
                selesai_dikerjakan: 0,
            }
        },
        methods: {
            actionRespon(e) {
            
                let id_soal = e.target.getAttribute('keyindex');
                let id_jenis_tes = e.target.getAttribute('keyjenistes');
                var jawabanSelected = e.target.getAttribute('keykode');
                console.log(e.target);

                const apiUrl = "{{ url('jawaban_soal') }}";
                axios.post(apiUrl, {
                        soal_id: id_soal,
                        jawaban: jawabanSelected,
                        id_jenis_tes: id_jenis_tes,
                    })
                    .then(response => {
                        var dataJawab = response.data;
                        console.log(response);
                        if (dataJawab.status == 'benar') {
                            this.kode_pilih = dataJawab.jawaban_benar;
                            this.notifTextAnswer = 'Jawaban Anda Benar';
                            this.score += parseFloat(5);
                        } else {
                            this.kode_salah = jawabanSelected;
                            this.notifTextAnswer = 'Jawaban Anda Salah';
                        }
                        this.kode_pilih = dataJawab.jawaban_benar;
                        setTimeout(this.getSoal, 2000);
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    });
                    this.isDisabled = true;
                // this.pkselected =  e.target.getAttribute('keypk');

            },
            getSoal() {
                this.kode_pilih = null;
                this.kode_salah = null;
                this.kode_non_selected = null;
                this.notifTextAnswer = null;
                const apiUrl = "{{ url('soal') }}" + "{{ $soal->id_jenis_tes }}";

                axios.get(apiUrl)
                .then(response => {
                        console.log(response);
                        this.dataSoal = response.data.data;
                        this.selesai_dikerjakan = collect(response.data.selesai_dikerjakan).count();
                        
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    });
                this.count_soal += 1;
                this.isDisabled = false;
            },


        },
        mounted() {
            this.getSoal();
        },
    });

</script>

@endsection
