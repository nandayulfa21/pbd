@extends('template/layout')

@section('judul')
    Form Input Produk
@endsection

@section('konten')
<form id="formData" enctype="multipart/form-data" method="POST" action="{{ url('produk') }}">
 @csrf
	<table>
		<tr>
			<td>Kode Produk</td>
			<td>
				<input class="form-control form-user-input" type="text" name="kode_produk" required="">
			</td>
		</tr>
		<tr>
			<td>Nama Produk</td>
			<td>
				<input class="form-control form-user-input" type="text" name="nama_produk"  required="">
			</td>
		</tr>
		<tr>
			<td>Deskripsi Produk</td>
			<td>
				<textarea class="form-control form-user-input" name="deskripsi" required=""></textarea>
			</td>
		</tr>
		<tr>
			<td>Stok</td>
			<td>
				<input class="form-control form-user-input" type="number" name="stok_produk" min="0"  required="">
			</td>
		</tr>
		<tr>
			<td>Harga Jual</td>
			<td>
				<input class="form-control form-user-input" type="number" name="harga_jual" min="0" max="100000"  required="">
			</td>
		</tr>
		<tr>
			<td>Foto Produk</td>
			<td>
				<div class="row" id="dropPhoto">
				<div class="col upload-area">
				<input type="file" class="form-user-input" name="file" id="file">
				<h2>Jatuhkan Foto Disini</h2>
				</div>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<input class="btn btn-primary" type="submit" name="submit" value="Simpan Data">
				<a href="{{ url('produk') }}" class="btn btn-danger">Kembali Ke Daftar Prouk</a>
			</td>
		</tr>
	</table>
</form>

<style type="text/css">
 .upload-area {
 width: 70%;
 height: 150px;
 border: 2px solid lightgray;
 border-radius: 3px;
 margin: 0 auto;
 text-align: center;
 overflow: auto;
}
 .upload-area:hover {
 cursor: pointer;
 }
 .upload-area h2 {
 text-align: center;
 font-weight: normal;
 font-family: sans-serif;
 line-height: 50px;
 color: gray;
 }
 #file {
 display: none;
 }
</style>
@endsection

@section('script_custom')
<script>
    $(document).ready(function(){

			// $('#formData').on('submit', function (e) {
			// 	e.preventDefault();
			// 	sendData();
			// })

        function sendData() {
            var url_post = '{{ url("api/produk/input") }}';

            var dataForm = {};
            var allInput = $(".form-user-input");

            $.each (allInput, function (i, val) {
                dataForm[val['name']] = val['value'];
            });

            $.ajax(url_post, {
                type: 'POST',
                data: dataForm,
                success: function (data, status, xhr) {
                    var data_str = JSON.parse(data);

                    alert(data_str['pesan']);
                },
                error: function (jqXHR, textStatus, errorMessage) {
                    alert('Error : ' + jqXHR.responseJSON.message);
                }
            })
        }
    })
</script>
<script type="text/javascript">
$("html").on("drop", function (e) {
e.preventDefault();
e.stopPropagation();
});
$("html").on("dragover", function (e) {
e.preventDefault();
e.stopPropagation();
$(".upload-area > h2").text("Arahkan Kesini");
});
$(".upload-area").on("dragenter", function (e) {
e.preventDefault();
e.stopPropagation();
$(".upload-area > h2").text("Jatuhkan File !!");
});
$(".upload-area").on("dragover", function (e) {
e.preventDefault();
e.stopPropagation();
$(".upload-area > h2").text("Jatuhkan File !!");
});
$(".upload-area").on("drop", function (e) {
e.preventDefault();
e.stopPropagation();
var file = e.originalEvent.dataTransfer.files;
console.log(file);
$("#file")[0].files = file;
$(".upload-area > h2").text("File yang dipilih : " + file[0].name);
});
$(".upload-area > h2").on("click", function (e) {
$("#file").click();
});
$("#file").on("change", function (e) {
var file = $("#file")[0].files[0];
console.log(file);
$(".upload-area > h2").text("File yang dipilih : " + file.name);
});
</script>
@endsection
