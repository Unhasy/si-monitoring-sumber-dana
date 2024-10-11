@extends('admin/template/layout')
@section('content')
<div id="app-laman">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nomenklatur</h3>
          
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-xs-12">
                    <input type="text" v-model="keyword" @keypress.enter="fetchData" class="form-control" placeholder="Cari Data ... (enter)">
                </div>
                <div class="col-md-9 col-xs-12">
                    <button @click="showCreateModal" class="btn btn-primary float-end"><i class="fa-solid fa-circle-plus"></i> &nbsp; Nomenklatur</button>
                </div>
            </div>
            <!-- Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kategori</th>
                        <th>Kode Rekening</th>
                        <th>Nomenklatur</th>
                        <th><center>Opsi</center></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(nomen, index) in nomenklaturs" :key="nomen.id">
                        <td>@{{ (currentPage - 1) * perPage + index + 1 }}</td>
                        <td>@{{ nomen.kategori }}</td>
                        <td>@{{ nomen.kode_rekening }}</td>
                        <td>@{{ nomen.nomenklatur }}</td>
                        <td>
                            <center>
                                <button @click="editData(nomen.id)" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button @click="deleteData(nomen.id)" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                            </center>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Pagination -->
            <nav>
                <ul class="pagination">
                    <li class="page-item" :class="{ disabled: currentPage === 1 }">
                        <a class="page-link" @click="changePage(currentPage - 1)">Previous</a>
                    </li>
                    <li v-for="page in totalPages" :key="page" class="page-item" :class="{ active: page === currentPage }">
                        <a class="page-link" @click="changePage(page)">@{{ page }}</a>
                    </li>
                    <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                        <a class="page-link" @click="changePage(currentPage + 1)">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Modal for Create/Edit  -->
    <div v-if="modalVisible" class="modal-backdrop fade show"></div>
    <div class="modal fade" :class="{ show: modalVisible }" :style="{ display: modalVisible ? 'block' : 'none' }" aria-hidden="!modalVisible" id="staticBackdrop" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nomenklatur</h5>
                </div>
                <form @submit.prevent="saveData">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kategori</label>
                            <select v-model="form.kategori" class="form-select" required placeholder="Pilih Role">
                                <option value="URUSAN">URUSAN</option>
                                <option value="BIDANG URUSAN">BIDANG URUSAN</option>
                                <option value="PROGRAM">PROGRAM</option>
                                <option value="KEGIATAN">KEGIATAN</option>
                                <option value="SUB KEGIATAN">SUB KEGIATAN</option>
                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Kode Rekening</label>
                            <input type="text" v-model="form.kode_rekening" class="form-control" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Nomenklatur</label>
                            <input type="text" v-model="form.nomenklatur" class="form-control" required>
                        </div>
                        <br>
                        <input type="hidden" v-model="form.master_dasar_hukum_id">
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
    new Vue({
        el: '#app',
        data: {
            sidebar_show: true, // wajib config

            nomenklaturs: [],
            currentPage: 1,
            perPage: 200,
            totalPages: 0,
            modalVisible: false,
            keyword:"",
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
                axios.get('/master/nomenklatur/data', {
                    params: {
                        page: this.currentPage,
                        perPage: this.perPage,
                        keyword: this.keyword
                    }
                }).then(response => {
                    this.nomenklaturs = response.data.data;
                    this.totalPages = Math.ceil(response.data.total / this.perPage);
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
                if(this.form.role=='ADMIN') {
                    this.form.kode_opd = ''
                }
                if (this.form.id) {
                    axios.put(`/master/nomenklatur/${this.form.id}`, this.form)
                        .then(response => {
                            this.fetchData();
                            this.modalVisible = false;
                        });
                } else {
                    axios.post('/master/nomenklatur', this.form)
                        .then(response => {
                            this.fetchData();
                            this.modalVisible = false;
                        });
                }
            },
            editData(id) {
                axios.get(`/master/nomenklatur/${id}/edit`).then(response => {
                    this.form = response.data;
                    this.modalVisible = true;
                });
            },
            deleteData(id) {
                if (confirm('Are you sure you want to delete this data?')) {
                    axios.delete(`/master/nomenklatur/${id}`).then(response => {
                        this.fetchData();
                    });
                }
            }
        }
    });
</script>
@endsection