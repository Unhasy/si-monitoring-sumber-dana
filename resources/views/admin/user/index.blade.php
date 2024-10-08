@extends('admin/template/layout')
@section('content')
<div id="app-laman">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User</h3>
          
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-xs-12">
                    <input type="text" v-model="keyword" @keypress.enter="fetchUsers" class="form-control" placeholder="Cari Data ... (enter)">
                </div>
                <div class="col-md-9 col-xs-12">
                    <button @click="showCreateModal" class="btn btn-primary float-end"><i class="fa-solid fa-circle-plus"></i> &nbsp; User</button>
                </div>
            </div>
            <!-- Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>OPD</th>
                        <th><center>Opsi</center></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in users" :key="user.id">
                        <td>@{{ (currentPage - 1) * perPage + index + 1 }}</td>
                        <td>@{{ user.name }}</td>
                        <td>@{{ user.email }}</td>
                        <td>@{{ user.role }}</td>
                        <td>@{{ user.kode_opd }}</td>
                        <td>
                            <center>
                                <button @click="editUser(user.id)" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button @click="deleteUser(user.id)" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
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

    <!-- Modal for Create/Edit User -->
    <div v-if="modalVisible" class="modal-backdrop fade show"></div>
    <div class="modal fade" :class="{ show: modalVisible }" :style="{ display: modalVisible ? 'block' : 'none' }" aria-hidden="!modalVisible" id="staticBackdrop" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User</h5>
                </div>
                <form @submit.prevent="saveUser">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" v-model="form.name" class="form-control" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" v-model="form.email" class="form-control" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Role</label>
                            <select v-model="form.role" class="form-select" required placeholder="Pilih Role">
                                <option value="ADMIN">ADMIN</option>
                                <option value="KEPALA">KEPALA</option>
                                <option value="OPERATOR">OPERATOR</option>
                            </select>
                        </div>
                        <br>
                        <div class="form-group" v-show="form.role=='KEPALA' || form.role=='OPERATOR'">
                            <label>OPD</label>
                            <select v-model="form.kode_opd" class="form-select" placeholder="Pilih OPD">
                                <option v-for="(op,index) in opd" :key="index" :value="op.kode_opd">@{{op.nama_opd}}</option>
                            </select>
                        </div>
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

            users: [],
            currentPage: 1,
            perPage: 10,
            totalPages: 0,
            modalVisible: false,
            keyword:"",
            form: {
                id: null,
                name: '',
                email: '',
                role: '',
                kode_opd: '',
                password: '123456'
            },
            opd:[]
        },
        mounted() {
            this.fetchUsers();
            this.fetchOpd();
        },
        methods: {
            fetchUsers() {
                axios.get('/master/user/data', {
                    params: {
                        page: this.currentPage,
                        perPage: this.perPage,
                        keyword: this.keyword
                    }
                }).then(response => {
                    this.users = response.data.data;
                    this.totalPages = Math.ceil(response.data.total / this.perPage);
                });
            },
            fetchOpd() {
                axios.get('/master/user/opd').then(response => {
                    this.opd = response.data
                });
            },
            changePage(page) {
                if (page < 1 || page > this.totalPages) return;
                this.currentPage = page;
                this.fetchUsers();
            },
            showCreateModal() {
                this.clearForm();
                this.modalVisible = true;
            },
            clearForm() {
                this.form = {
                    id: null,
                    name: '',
                    email: '',
                    role: '',
                    kode_opd: '',
                    password: '@123456pass'
                };
            },
            saveUser() {
                if(this.form.role=='ADMIN') {
                    this.form.kode_opd = ''
                }
                if (this.form.id) {
                    axios.put(`/master/user/${this.form.id}`, this.form)
                        .then(response => {
                            this.fetchUsers();
                            this.modalVisible = false;
                        });
                } else {
                    axios.post('/master/user', this.form)
                        .then(response => {
                            this.fetchUsers();
                            this.modalVisible = false;
                        });
                }
            },
            editUser(id) {
                axios.get(`/master/user/${id}/edit`).then(response => {
                    this.form = response.data;
                    this.modalVisible = true;
                });
            },
            deleteUser(id) {
                if (confirm('Are you sure you want to delete this user?')) {
                    axios.delete(`/master/user/${id}`).then(response => {
                        this.fetchUsers();
                    });
                }
            }
        }
    });
</script>
@endsection