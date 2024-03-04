@extends('admin.layout')
@section('content')
<div class="row gy-5 g-xl-8">
    <div class="col-xl-12">
        <div class="card card-xl-stretch mb-5 mb-xl-8">
            <div class="card-body py-3" id="app">
                <div class="row">
                  
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 form-group">
                        <div class="card">
                            <div v-if="count_soal <= <?= $totalSoalTersedia ?>">
                                <div class="card-header">
                                    <h3>Soal @{{ count_soal }}</h3>
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
                                                }" :keyindex="soal.id_soal" :keykode="jawaban.kode_jawaban"
                                                @click="actionRespon">
                                                    <img :src="jawaban.url_file_tambahan" style="width:40%; margin-bottom:50px;" alt="" v-if="jawaban.url_file_tambahan">
                                                    <span v-if="!jawaban.url_file_tambahan">@{{ jawaban.kode_jawaban }} - @{{ jawaban.keterangan }}</span>
                                                    
                                                    
                                                </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p class="notifikasi-text-answer">@{{ notifTextAnswer }} </p>
                                            <h4>Total Score @{{ score }} dari 5 Soal.</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <div class="card-body text-center">
                                    <h2 class="card-text elment-soal">Latihan Soal selesai dengan Scoore Akhir :
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
                score: 0,
                count_soal: 0,
            }
        },
        methods: {
            actionRespon(e) {
            
                let soalRow = this.dataSoal[0];
                var jawabanSelected = e.target.getAttribute('keykode');;

                const apiUrl = 'http://localhost:8000/jawaban_soal';
                axios.post(apiUrl, {
                        soal_id: soalRow.id_soal,
                        jawaban: jawabanSelected
                    })
                    .then(response => {
                        var dataJawab = response.data;
                        console.log(response.data);
                        if (dataJawab.status == 'benar') {
                            this.kode_pilih = dataJawab.jawaban_benar;
                            this.notifTextAnswer = 'Jawaban Anda Benar';
                            this.score += 5;
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
                const apiUrl = 'http://localhost:8000/soal_exam/';

                axios.get(apiUrl)
                    .then(response => {
                        console.log(response.data.data);
                        this.dataSoal = response.data.data;
                        console.log(this.dataSoal);
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
