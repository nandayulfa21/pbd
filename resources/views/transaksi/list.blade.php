@extends('template/layout')

@section('judul')
    List Transaksi
@endsection

@section('konten')
<link rel="stylesheet" type="text/css" href="{{ url('DataTables/DataTables-
1.10.25/css/dataTables.bootstrap4.min.css') }}">

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
                // d.stok = $("#cari").val();
       		}
		},

	});

    $("form").on('submit', function(e){
        e.preventDefault();
        tabel.ajax.reload();
    })
</script>
@endsection
