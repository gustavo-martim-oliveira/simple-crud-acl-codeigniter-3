<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">

    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?= base_url('dashboard') ?>" class="nav-link">Home</a>
    </li>

		<?php
		if(can('users_view')){
		?>
			<li class="nav-item d-none d-sm-inline-block">
				<a href="<?= base_url('users') ?>" class="nav-link">Usuários</a>
			</li>
		<?php
		}
		?>

		<?php
		if(can('permissions_view')){
		?>
				<li class="nav-item d-none d-sm-inline-block">
					<a href="#" class="nav-link">Permissões de acesso</a>
				</li>
		<?php
		}
		?>

		<?php
		if(can('categories_view')){
		?>
				<li class="nav-item d-none d-sm-inline-block">
					<a href="#" class="nav-link">Categorias</a>
				</li>
		<?php
		}
		?>

		<?php
		if(can('articles_view')){
		?>
				<li class="nav-item d-none d-sm-inline-block">
					<a href="#" class="nav-link">Artigos</a>
				</li>
		<?php
		}
		?>

		<li class="nav-item d-none d-sm-inline-block">
      <a href="<?= base_url('auth/logout') ?>" class="nav-link">Logout</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
  </ul>
</nav>
<!-- /.navbar -->