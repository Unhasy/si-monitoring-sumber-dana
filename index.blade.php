@extends('admin/template/layout')
@section('content')
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card text-white bg-secondary" style="height: 110px;">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4 fw-semibold"> 315 </div>
                    <div>Sumber Dana</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-6 col-xl-3">
        <div class="card text-white bg-secondary" style="height: 110px;">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4 fw-semibold"> 4436 </div>
                    <div>Nomenklatur</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-6 col-xl-3">
        <div class="card text-white bg-secondary" style="height: 110px;">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4 fw-semibold"> 12 % </div>
                    <div>Realisasi Bulan Oktober</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-6 col-xl-3">
        <div class="card text-white bg-secondary" style="height: 110px;">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4 fw-semibold"> 85 % </div>
                    <div>Realisasi Total</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div id="canvas-1" width="100%" style="height: 700px"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Highcharts.chart('canvas-1', {
            credits: {
                enabled: false
            },
            chart: {
                type: 'area'
            },
            title: {
                useHTML: true,
                text: 'Pagu vs Realisasi Per Bulan',
                align: 'center'
            },
            subtitle: {
                text: 'Sumber: SIM Monitoring Sumber Dana',
                align: 'center'
            },
            yAxis: {
                labels: {
                    format: '{value}%'
                },
                title: {
                    enabled: false
                }
            },
            xAxis: {
                categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                tickmarkPlacement: 'on',
                title: {
                    enabled: false
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>' +
                    ': <b>{point.percentage:.1f}%</b> (Rp. {point.y:,.1f})<br/>',
                split: true
            },
            plotOptions: {
                series: {
                    pointStart: 0
                },
                area: {
                    stacking: 'percent',
                    marker: {
                        enabled: false
                    }
                }
            },
            series: [{
                name: 'Pagu',
                data: [
                    10000000000,10000000000,10000000000,10000000000,10000000000,10000000000,10000000000,10000000000,10000000000,10000000000,10000000000,10000000000,
                ]
            }, {
                name: 'Realisasi',
                color: '#16a085',
                data: [
                    200000000, 600000000, 900000000, 1200000000,9000000000, 10000000000, 20000000000, 40000000000, 50000000000, 60000000000
                ]
            }]
        });
    });



    new Vue({
        el: '#app',
        data: {
            sidebar_show: true, // wajib config
        },
        mounted() {},
        methods: {}
    });</script>
@endsection