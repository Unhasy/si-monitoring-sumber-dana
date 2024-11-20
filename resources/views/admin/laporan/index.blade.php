@extends('admin/template/layout')
@section('content')
<div id="app-laman" class="row">
    <div class="col-md-12">

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
        },
        mounted() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                // axios.get('/realisasi/data', {
                //     params: {
                //         kode_opd: this.kode_opd,
                //     }
                // }).then(response => {
                //     this.realisasis = response.data;
                // });
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