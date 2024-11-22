@extends('admin/template/layout')
@section('content')
<div id="app-laman" class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><center>No</center></th>
                    <th><center>Kode</center></th>
                    <th><center>Sumber Dana</center></th>
                    <th><center>Pagu</center></th>
                    <th><center>Realisasi</center></th>
                    <th><center>Presentase</center></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in laporans" :key="item.id">
                    <td><center>@{{ index+1 }}</center></td>
                    <td>@{{ item.kode_rekening }}</td>
                    <td>@{{ item.keterangan }}</td>
                    <td class="text-end">
                        @{{ formatNumber(item.total_pagu) }}
                    </td>
                    <td class="text-end">
                        @{{ formatNumber(item.total_realisasi) }}
                    </td>
                    <td class="text-end">
                        <span style="float: right">@{{ (item.total_realisasi/item.total_pagu * 100).toFixed(2)}} %</span>
                    </td>
                </tr>
            </tbody>
        </table>
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
        },
        mounted() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                axios.get('/laporan/data-admin', {
                    params: {
                        kode_opd: this.kode_opd,
                    }
                }).then(response => {
                    this.laporans = response.data.data;
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