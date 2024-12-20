@extends('admin/template/layout')
@section('content')
<div id="app-laman" class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><center>Kode Rekening</center></th>
                    <th><center>Nomenklatur</center></th>
                    <th><center>Pagu</center></th>
                    <th><center>Realisasi</center></th>
                    <th><center>Presentase</center></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in realisasis" :key="item.id">
                    <td :style="getStyle(item.kategori)">@{{ item.kode_rekening }}</td>
                    <td :style="getStyle(item.kategori)">@{{ item.nomenklatur }}</td>
                    <td :style="getStyle(item.kategori)" class="text-end">
                        @{{ formatNumber(item.pagu) }}
                    </td>
                    <td :style="getStyle(item.kategori)" class="text-end">
                        @{{ formatNumber(item.realisasi) }}
                        <button
                            v-if="item.kategori === 'SUB KEGIATAN'"
                            @click="editData(item.id, item)"
                            class="btn btn-warning btn-sm"
                        >
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </td>
                    <td :style="getStyle(item.kategori)" class="text-end">
                        <span style="float: right">@{{ (item.realisasi/item.pagu * 100).toFixed(2)}} %</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Modal for Create/Edit  -->
    <div v-if="modalVisible" class="modal-backdrop fade show"></div>
    <div class="modal fade" :class="{ show: modalVisible }" :style="{ display: modalVisible ? 'block' : 'none' }" aria-hidden="!modalVisible" id="staticBackdrop" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sumberdana</h5>
                </div>
                <form @submit.prevent="saveData">
                    <div class="modal-body">
                        <table class="table">
                            <tr>
                                <th>Kode Sub Kegiatan</th>
                                <td>@{{sub_kegiatan.kode_rekening}}</td>
                            </tr>
                            <tr>
                                <th>Nama Sub Kegiatan</th>
                                <td>@{{sub_kegiatan.nomenklatur}}</td>
                            </tr>
                        </table>
                        <br>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Sumber Dana</th>
                                    <th>Pagu</th>
                                    <th>Realisasi</th>
                                    <th>Presentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(dana,index) in sumberdanas">
                                    <td>@{{index+1}}</td>
                                    <td>@{{dana.kode_rekening}} - @{{dana.keterangan}}</td>
                                    <td>
                                        @{{formatNumber(dana.pagu)}}
                                    </td>
                                    <td>
                                       <input type="number" v-model="dana.realisasi" class="form-control text-end" placeholder="Realisasi ...">
                                    </td>
                                    <td>
                                        @{{ (dana.realisasi/dana.pagu * 100).toFixed(2)}} %
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr style="font-weight: bold">
                                  <td colspan="2">Total</td>
                                  <td>@{{formatNumber(sub_kegiatan.pagu)}}</td>
                                  <td> <span style="float: right;">@{{formatNumber(sub_kegiatan.realisasi)}}</span></td>
                                  <td>@{{ (sub_kegiatan.realisasi/sub_kegiatan.pagu * 100).toFixed(2)}} %</td>
                                </tr>
                            </tfoot>
                        </table>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" @click="modalVisible = false">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    var kodeOPD = "<?php echo auth()->user()->kode_opd; ?>";
    new Vue({
        el: '#app',
        data: {
            sidebar_show: true, // wajib config

            realisasis: [],
            currentPage: 1,
            perPage: 200000,
            totalPages: 0,
            modalVisible: false,
            keyword:"",
            kode_opd: kodeOPD,
            sumberdanas: [],
            sub_kegiatan:{
                pagu:0,
                realisasi:0
            }
        },
        watch: {
            sumberdanas: {
                handler(newValue, oldValue) {
                    let realisasi = 0;
                    for (let index = 0; index < this.sumberdanas.length; index++) {
                        const element = this.sumberdanas[index];
                        if(element.realisasi !== null) {
                            realisasi += parseInt(element.realisasi)
                        }
                    }
                    this.sub_kegiatan.realisasi = realisasi
                },
                deep: true
            }
        },
        mounted() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                axios.get('/realisasi/data', {
                    params: {
                        kode_opd: this.kode_opd,
                    }
                }).then(response => {
                    this.realisasis = response.data;
                });
            },

            changePage(page) {
                if (page < 1 || page > this.totalPages) return;
                this.currentPage = page;
                this.fetchData();
            },
            showCreateModal() {
                this.clearForm();
                this.modalVisible = true;
            },
            clearForm() {
                this.form = {
                    id: null,
                    master_dasar_hukum_id: 1,
                    kategori: '',
                    kode_rekening: '',
                    nomenklatur: '',
                };
            },
            saveData() {
                axios.post('/realisasi/sumberdana', {sumberdanas:this.sumberdanas})
                    .then(response => {
                        this.fetchData();
                        this.modalVisible = false;
                        console.log('response', response)
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        })
                    });
            },
            editData(id, item) {
                axios.get(`/realisasi/sumberdana/${id}/edit`).then(response => {
                    this.sumberdanas = response.data;
                    this.sub_kegiatan = item
                    this.modalVisible = true;
                });
            },
            getStyle(kategori) {
                switch (kategori) {
                    case "URUSAN":
                    return "font-weight: bold;";
                    case "BIDANG URUSAN":
                    return "font-weight: bold;";
                    case "PROGRAM":
                    return "font-weight: bold; background-color: #f7f7f7;";
                    case "KEGIATAN":
                    return "font-weight: 500; background-color: #fdffcf;";
                    case "SUB KEGIATAN":
                    return "font-weight: normal;";
                    default:
                    return "";
                }
            },
            formatNumber(number) {
                if (number == null || isNaN(number)) {
                    return "0"; // Nilai default jika tidak valid
                }
                return Number(number).toLocaleString("id-ID", { minimumFractionDigits: 0 });
            }
        }
    });
</script>
@endsection