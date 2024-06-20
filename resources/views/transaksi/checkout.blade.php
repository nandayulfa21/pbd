@extends('template/layout')

@section('judul')
    Form Konfirmasi Transaksi
@endsection

@section('konten')
<form action="{{ url('checkout') }}" method="POST">
    @csrf
    <table>
		<tr>
			<td>Nama</td>
			<td>
				<input class="form-control form-user-input" type="text" name="nama" required="">
			</td>
		</tr>
		<tr>
			<td>Alamat Jalan</td>
			<td>
				<textarea class="form-control" name="alamat_jalan" required=""></textarea>
			</td>
		</tr>
		<tr>
			<td>Provinsi</td>
			<td>
                <select name="provinsi" id="provinsi" class="form-control" required="" onchange="ambil_kota()">
                    <option value="">--Pilih Salah Satu--</option>
                </select>
			</td>
		</tr>
		<tr>
			<td>Kota</td>
			<td>
                <select name="kota" id="kota" class="form-control" required="" onchange="ambil_kecamatan()">
                    <option value="">--Pilih Salah Satu--</option>
                </select>
			</td>
		</tr>
		<tr>
			<td>Kecamatan</td>
			<td>
				<select name="kecamatan" id="kecamatan" class="form-control" required="">
                    <option value="">--Pilih Salah Satu--</option>
                </select>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<input class="btn btn-primary" type="submit" name="submit" value="Tambahkan ke Transaksi">
				<a href="{{ url('keranjang') }}" class="btn btn-danger">Kembali Ke Keranjang</a>
			</td>
		</tr>
	</table>
</form>
@endsection

@section('script_custom')
<script>
function ambil_prov() {
    var link = '{{ url("api/provinsi") }}';

    $.ajax(link, {
        type: 'GET',
        success : function (data, status, xhr) {
            $('#provinsi').html(data);
        },
        error : function (jqXHR, textStatus, errorMsg) {
            alert('Error Pengambilan Data Provinsi : ' + errorMsg);
        }
    })
}

ambil_prov();

function ambil_kota() {
    var prov = $('#provinsi').val().split("||");
    var link = '{{ url("api/kota/") }}' + '/' + prov[0];

    $.ajax(link, {
        type: 'GET',
        success : function (data, status, xhr) {
            $('#kota').html(data);
        },
        error : function (jqXHR, textStatus, errorMsg) {
            alert('Error Pengambilan Data Kota : ' + errorMsg);
        }
    })
}

function ambil_kecamatan() {
    var kota = $('#kota').val().split("||");
    var link = '{{ url("api/kecamatan/") }}' + '/' + kota[0];

    $.ajax(link, {
        type: 'GET',
        success : function (data, status, xhr) {
            $('#kecamatan').html(data);

        },
        error : function (jqXHR, textStatus, errorMsg) {
            alert('Error Pengambilan Data Kecamatan : ' + errorMsg);
        }
    })
}
</script>
@endsection
