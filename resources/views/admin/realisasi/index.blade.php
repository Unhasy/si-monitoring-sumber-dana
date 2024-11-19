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
                    <td :style="getStyle(item.kategori)">
                        @{{ formatNumber(item.realisasi) }}
                        <button
                        v-if="item.kategori === 'SUB KEGIATAN'"
                        @click="editData(item.id)"
                        class="btn btn-warning btn-sm"
                        >
                        <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </td>
                    <td :style="getStyle(item.kategori)"></td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Modal for Create/Edit  -->
    <div v-if="modalVisible" class="modal-backdrop fade show"></div>
    <div class="modal fade" :class="{ show: modalVisible }" :style="{ display: modalVisible ? 'block' : 'none' }" aria-hidden="!modalVisible" id="staticBackdrop" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sumberdana</h5>
                </div>
                <form @submit.prevent="saveData">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode Rekening</label>
                            <input type="text" v-model="form.kode_rekening" class="form-control" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" v-model="form.keterangan" class="form-control" required>
                        </div>
                        <br>
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
            form: {
                id: null,
                master_dasar_hukum_id: 1,
                kategori: '',
                kode_rekening: '',
                nomenklatur: '',
            },
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
            // saveData() {
            //     if(this.form.role=='ADMIN') {
            //         this.form.kode_opd = ''
            //     }
            //     if (this.form.id) {
            //         axios.put(`/master/nomenklatur/${this.form.id}`, this.form)
            //             .then(response => {
            //                 this.fetchData();
            //                 this.modalVisible = false;
            //             });
            //     } else {
            //         axios.post('/master/nomenklatur', this.form)
            //             .then(response => {
            //                 this.fetchData();
            //                 this.modalVisible = false;
            //             });
            //     }
            // },
            editData(id) {
                axios.get(`/realisasi/sumberdana/${id}/edit`).then(response => {
                    this.form = response.data;
                    this.modalVisible = true;
                });
            },
            // deleteData(id) {
            //     if (confirm('Are you sure you want to delete this data?')) {
            //         axios.delete(`/master/nomenklatur/${id}`).then(response => {
            //             this.fetchData();
            //         });
            //     }
            // }

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