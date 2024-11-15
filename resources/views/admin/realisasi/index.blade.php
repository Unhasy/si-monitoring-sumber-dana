@extends('admin/template/layout')
@section('content')
    <div class="row">
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
                    @foreach ($data as $data)
                        <?php $styleTD=""; ?>
                        @if($data->kategori=='URUSAN')
                            <?php $styleTD="font-weight:bold;"; ?>
                        @elseif ($data->kategori=='BIDANG URUSAN')
                            <?php $styleTD="font-weight:bold;"; ?>
                        @elseif ($data->kategori=='PROGRAM')
                            <?php $styleTD="font-weight:bold;background-color:#f7f7f7"; ?>
                        @elseif ($data->kategori=='KEGIATAN')
                            <?php $styleTD="font-weight:500;background-color:#fdffcf"; ?>
                        @elseif ($data->kategori=='SUB KEGIATAN')
                            <?php $styleTD="font-weight:normal;"; ?>
                        @endif
                        <tr>
                            <td style="<?=$styleTD?>">{{$data->kode_rekening}}</td>
                            <td style="<?=$styleTD?>">{{$data->nomenklatur}}</td>
                            <td style="<?=$styleTD?>" class="text-end">
                                @if($data->kategori=='SUB KEGIATAN')
                                    {{number_format($data->pagu, 0, ',', '.') }}
                                @endif
                            </td>
                            <td style="<?=$styleTD?>"></td>
                            <td style="<?=$styleTD?>"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    new Vue({
        el: '#app',
        data: {
            sidebar_show: true, // wajib config
        },
        mounted() {},
        methods: {}
    });</script>
@endsection