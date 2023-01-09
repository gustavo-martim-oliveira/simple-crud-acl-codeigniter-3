<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="index3.html" class="brand-link">
		<span class="brand-text font-weight-light">CRUD</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="info">
				<a href="#" class="d-block"><?= auth_user()->name ?></a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item ">
					<a href="<?= base_url('dashboard') ?>" class="nav-link active">
						<i class="nav-icon fas fa-th"></i>
						<p>
							Home
						</p>
					</a>
				</li>

				<?php
				if(can('users_view')){
				?>
					<li class="nav-item ">
						<a href="<?= base_url('users') ?>" class="nav-link">
							<i class="nav-icon fas fa-th"></i>
							<p>
								Usuários
							</p>
						</a>
					</li>
				<?php
				}
				?>

				<?php
				if(can('permissions_view')){
				?>
					<li class="nav-item ">
						<a href="<?= base_url('permissions') ?>" class="nav-link">
							<i class="nav-icon fas fa-th"></i>
							<p>
								Permissões de acesso
							</p>
						</a>
					</li>
				<?php
				}
				?>

				<?php
				if(can('categories_view')){
				?>
					<li class="nav-item ">
						<a href="#" class="nav-link">
							<i class="nav-icon fas fa-th"></i>
							<p>
								Categorias
							</p>
						</a>
					</li>
				<?php
				}
				?>

				<?php
				if(can('articles_view')){
				?>
					<li class="nav-item ">
						<a href="#" class="nav-link">
							<i class="nav-icon fas fa-th"></i>
							<p>
								Artigos
							</p>
						</a>
					</li>
				<?php
				}
				?>

				<li class="nav-item ">
					<a href="<?= base_url('auth/logout') ?>" class="nav-link">
						<i class="nav-icon fas fa-th"></i>
						<p>
							Logout
						</p>
					</a>
				</li>

			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
<!-- /.sidebar -->
</aside>
