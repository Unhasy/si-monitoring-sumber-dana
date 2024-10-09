@extends('admin/template/layout')
@section('content')
<div id="app-laman">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sumberdana</h3>
          
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-xs-12">
                    <input type="text" v-model="keyword" @keypress.enter="fetchData" class="form-control" placeholder="Cari Data ... (enter)">
                </div>
                <div class="col-md-9 col-xs-12">
                    <button @click="showCreateModal" class="btn btn-primary float-end"><i class="fa-solid fa-circle-plus"></i> &nbsp; Sumberdana</button>
                </div>
            </div>
            <!-- Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Rekening</th>
                        <th>Keterangan</th>
                        <th><center>Opsi</center></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(dana, index) in sumberdanas" :key="dana.id">
                        <td>@{{ (currentPage - 1) * perPage + index + 1 }}</td>
                        <td>@{{ dana.kode_rekening }}</td>
                        <td>@{{ dana.keterangan }}</td>
                        <td>
                            <center>
                                <button @click="editData(dana.id)" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button @click="deleteData(dana.id)" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
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
    new Vue({
        el: '#app',
        data: {
            sidebar_show: true, // wajib config

            sumberdanas: [],
            currentPage: 1,
            perPage: 200,
            totalPages: 0,
            modalVisible: false,
            keyword:"",
            form: {
                id: null,
                kode_rekening: '',
                keterangan: '',
            },
        },
        mounted() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                axios.get('/master/sumberdana/data', {
                    params: {
                        page: this.currentPage,
                        perPage: this.perPage,
                        keyword: this.keyword
                    }
                }).then(response => {
                    this.sumberdanas = response.data.data;
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
                    kode_rekening: '',
                    keterangan: '',
                };
            },
            saveData() {
                if(this.form.role=='ADMIN') {
                    this.form.kode_opd = ''
                }
                if (this.form.id) {
                    axios.put(`/master/sumberdana/${this.form.id}`, this.form)
                        .then(response => {
                            this.fetchData();
                            this.modalVisible = false;
                        });
                } else {
                    axios.post('/master/sumberdana', this.form)
                        .then(response => {
                            this.fetchData();
                            this.modalVisible = false;
                        });
                }
            },
            editData(id) {
                axios.get(`/master/sumberdana/${id}/edit`).then(response => {
                    this.form = response.data;
                    this.modalVisible = true;
                });
            },
            deleteData(id) {
                if (confirm('Are you sure you want to delete this data?')) {
                    axios.delete(`/master/sumberdana/${id}`).then(response => {
                        this.fetchData();
                    });
                }
            }
        }
    });
</script>
@endsection