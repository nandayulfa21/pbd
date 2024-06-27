@extends('template/layout')

@section('judul')
    Laporan Transaksi
@endsection

@section('konten')
<link rel="stylesheet" type="text/css" href="{{ url('Chartist/chartist.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ url('DataTables/DataTables-
1.10.25/css/dataTables.bootstrap4.min.css') }}">

    <form>
        <div class="row">
            <div class="col">
                <label>Tanggal Awal</label>
                <input class="form-control" type="date" name="tgl_awal" id="tgl_awal" onchange="cekLaporan()">
            </div>
            <div class="col">
                <label>Tanggal Akhir</label>
                <input class="form-control" type="date" name="tgl_akhir" id="tgl_akhir" onchange="cekLaporan()">
            </div>
        </div>
    </form>

    <div id="chartHours" class="ct-chart"></div>

    <hr/>

    <table border="1" id="data-list" class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Nominal</th>
            </tr>
        </thead>
    </table>

    <div class="footer">
        <div class="legend">
            <i class="fa fa-circle text-info"></i> Total Nominal Transaksi : Rp <span id="total_data"></span>
        </div>
        <hr>
        <div class="stats">
            <i class="fa fa-history"></i> Per Tanggal <span id="tgl_data"></span>
        </div>
    </div>
@endsection

@section('script_custom')
<script type="text/javascript" src="{{ url('DataTables/datatables.min.js') }}"></script>

    <script type="text/javascript">
        var url = '{{ url("api/transaksi/dataTable") }}';

        var tabel = $("#data-list").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: url,
                data: function (d) {
                    d.tgl_awal = $("#tgl_awal").val();
                    d.tgl_akhir = $("#tgl_akhir").val();
                }
            },

        });
    </script>

    <script src="{{ url('Chartist/chartist.min.js') }}"></script>
    <script type="text/javascript">
        var dataSales = {
            labels: [],
            series: []
        };

        function initChartist() {
            var optionsSales = {
                lineSmooth: false,
                low: 0,
                showArea: true,
                height: "250px",
                axisX: {
                    showGrid: false,
                },
                lineSmooth: Chartist.Interpolation.simple({
                    divisor: 3
                }),
                showLine: true,
                showPoint: false,
            };
            var responsiveSales = [
                ['screen and (max-width: 640px)', {
                    axisX: {
                        labelInterpolationFnc: function(value) {
                            return value[0];
                        }
                    }
                }]
            ];
            Chartist.Line('#chartHours', dataSales, optionsSales, responsiveSales);
        }

        function cekLaporan() {
            var link = '{{ url("api/transaksi/laporan") }}' + '?tanggal_awal=' + $('#tgl_awal').val()+ '&tanggal_akhir=' + $('#tgl_akhir').val();
            $.ajax(link, {
                type: 'GET',
                success: function(data, status, xhr) {
                    var objData = JSON.parse(data);
                    dataSales.labels = objData['label'];
                    dataSales.series = objData['data'];
                    $("#total_data").text(objData['total']);
                    $("#tgl_data").text(objData['tgl_update']);
                    initChartist();
                    tabel.ajax.reload();
                },
                error: function(jqXHR, textStatus, errorMsg) {
                    alert('Error : ' + errorMsg);
                    $('title').html('Error');
                }
            })
        }
        cekLaporan();
        interval_global = setInterval(function(){ cekLaporan(); }, 5000);
    </script>
@endsection
