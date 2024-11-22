@extends('admin/template/layout')
@section('content')
<div id="app-laman" class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><center>Kode</center></th>
                    <th><center>OPD</center></th>
                    <th><center>Pagu</center></th>
                    <th><center>Realisasi</center></th>
                    <th><center>Presentase</center></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in laporans" :key="item.id">
                    <td>@{{ item.kode_opd }}</td>
                    <td>@{{ item.nama_opd }}</td>
                    <td class="text-end">
                        @{{ formatNumber(item.pagu) }}
                    </td>
                    <td class="text-end">
                        @{{ formatNumber(item.realisasi) }}
                    </td>
                    <td class="text-end">
                        <span style="float: right">@{{ (item.realisasi/item.pagu * 100).toFixed(2)}} %</span>
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-show="loading">
            <center>
                <i class="fa fa-spin fa-spinner" style="font-size: 40px"></i>
            </center>
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

            laporans:[],
            loading:false
        },
        mounted() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                this.loading = true
                axios.get('/realisasi/data-admin').then(response => {
                    this.laporans = response.data;
                    this.loading = false
                });
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