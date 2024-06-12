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
                <select name="provinsi" id="provinsi" class="form-control" required="">
                    <option value="">--Pilih Salah Satu--</option>
                </select>
			</td>
		</tr>
		<tr>
			<td>Kota</td>
			<td>
                <select name="kota" id="kota" class="form-control" required="">
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

@endsection
