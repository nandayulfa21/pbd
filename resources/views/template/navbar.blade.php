<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="{{ url('adminLTE/index3.html') }}" class="brand-link">
		<img src="{{ url('adminLTE/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">AdminLTE 3</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="{{ url('adminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block">Admin</a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="{{ url('produk') }}" class="nav-link">
						<i class="fas fa-circle nav-icon"></i>
						<p>List Barang</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ url('produk/form') }}" class="nav-link">
						<i class="fas fa-circle nav-icon"></i>
						<p>Form Inputan Barang</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ url('keranjang') }}" class="nav-link">
						<i class="fas fa-circle nav-icon"></i>
						<p>Keranjang</p>
					</a>
				</li>
                <li class="nav-item">
					<a href="{{ url('transaksi') }}" class="nav-link">
						<i class="fas fa-circle nav-icon"></i>
						<p>Transaksi</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ url('login') }}" class="nav-link">
						<i class="fas fa-circle nav-icon"></i>
						<p>Login</p>
					</a>
				</li>
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>
