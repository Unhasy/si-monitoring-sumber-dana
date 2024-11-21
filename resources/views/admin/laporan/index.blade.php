@extends('admin/template/layout')
@section('content')
<div id="app-laman" class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><center>Kode</center></th>
                    <th><center>Sumber Dana</center></th>
                    <th><center>Pagu</center></th>
                    <th><center>Realisasi</center></th>
                    <th><center>Presentase</center></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in laporans" :key="item.id">
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
            <tfoot>
                <tr style="font-weight: bold">
                    <td colspan="2"><center>Total</center></td>
                    <td class="text-end">
                        @{{ formatNumber(total_laporan.total_pagu) }}
                    </td>
                    <td class="text-end">
                        @{{ formatNumber(total_laporan.total_realisasi) }}
                    </td>
                    <td class="text-end">
                       @{{ total_laporan.total_presentase}} %
                    </td>
                </tr>
            </tfoot>
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
            total_laporan:{
                total_pagu:0,
                total_realisasi:0,
                total_presentase:0
            }
        },
        mounted() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                axios.get('/laporan/data', {
                    params: {
                        kode_opd: this.kode_opd,
                    }
                }).then(response => {
                    this.laporans = response.data.data;
                    this.total_laporan = {
                        total_pagu:response.data.total[0].pagu,
                        total_realisasi:response.data.total[0].realisasi,
                        total_presentase:(parseInt(response.data.total[0].realisasi)/parseInt(response.data.total[0].pagu) * 100).toFixed(2)
                    }
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