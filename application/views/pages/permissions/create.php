  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid py-3">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-12">
            <div class="card">
              <div class="card-header">
				<div class="d-flex justify-content-between align-items-center w-100">
					<h5 class="m-0">Criar permissão</h5>
				</div>
              </div>
              <div class="card-body">
  				<form method="post" action="<?= base_url('permissions/store') ?>">
  					<div class="row">
					  	<div class="col-md-12">
							<div class="form-group">
								<label for="title">Título</label>
								<input type="text" class="form-control" id="title" name="title" placeholder="Título" required value="<?=(isset($_SESSION['__formOld']['title']) ? $_SESSION['__formOld']['title'] : '')?>">
							</div>
						</div>

						<div class="col-md-3">
							<div class="card card-secondary">
								<div class="card-header">
									<h3 class="card-title">Usuários</h3>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<div class="row">
										<div class="col-12">
											<!-- checkbox -->
											<div class="form-group">
											<div class="custom-control custom-checkbox">
													<input class="custom-control-input"type="checkbox" name="permission[users_view]" id="permissionUsers1" value="1">
													<label for="permissionUsers1" class="custom-control-label">Listar</label>
												</div>
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input"type="checkbox" name="permission[users_create]" id="permissionUsers2" value="1">
													<label for="permissionUsers2" class="custom-control-label">Criar</label>
												</div>
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input"type="checkbox" name="permission[users_update]" id="permissionUsers3" value="1">
													<label for="permissionUsers3" class="custom-control-label">Editar</label>
												</div>
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input"type="checkbox" name="permission[users_delete]" id="permissionUsers4" value="1">
													<label for="permissionUsers4" class="custom-control-label">Excluir</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- /.card-body -->
							</div>
						</div>

						<div class="col-md-3">
							<div class="card card-secondary">
								<div class="card-header">
									<h3 class="card-title">Permissões de acesso</h3>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<div class="row">
										<div class="col-12">
											<!-- checkbox -->
											<div class="form-group">
											<div class="custom-control custom-checkbox">
													<input class="custom-control-input"type="checkbox" name="permission[permissions_view]" id="permissionsPermissions1" value="1">
													<label for="permissionsPermissions1" class="custom-control-label">Listar</label>
												</div>
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input"type="checkbox" name="permission[permissions_create]" id="permissionsPermissions2" value="1">
													<label for="permissionsPermissions2" class="custom-control-label">Criar</label>
												</div>
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input"type="checkbox" name="permission[permissions_update]" id="permissionsPermissions3" value="1">
													<label for="permissionsPermissions3" class="custom-control-label">Editar</label>
												</div>
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input"type="checkbox" name="permission[permissions_delete]" id="permissionsPermissions4" value="1">
													<label for="permissionsPermissions4" class="custom-control-label">Excluir</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- /.card-body -->
							</div>
						</div>

						<div class="col-md-3">
							<div class="card card-secondary">
								<div class="card-header">
									<h3 class="card-title">Categorias</h3>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<div class="row">
										<div class="col-12">
											<!-- checkbox -->
											<div class="form-group">
											<div class="custom-control custom-checkbox">
													<input class="custom-control-input"type="checkbox" name="permission[categories_view]" id="permissionCategorie1" value="1">
													<label for="permissionCategorie1" class="custom-control-label">Listar</label>
												</div>
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input"type="checkbox" name="permission[categories_create]" id="permissionCategorie2" value="1">
													<label for="permissionCategorie2" class="custom-control-label">Criar</label>
												</div>
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input"type="checkbox" name="permission[categories_update]" id="permissionCategorie3" value="1">
													<label for="permissionCategorie3" class="custom-control-label">Editar</label>
												</div>
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input"type="checkbox" name="permission[categories_delete]" id="permissionCategorie4" value="1">
													<label for="permissionCategorie4" class="custom-control-label">Excluir</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- /.card-body -->
							</div>
						</div>

						<div class="col-md-3">
							<div class="card card-secondary">
								<div class="card-header">
									<h3 class="card-title">Artigos</h3>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<div class="row">
										<div class="col-12">
											<!-- checkbox -->
											<div class="form-group">
											<div class="custom-control custom-checkbox">
													<input class="custom-control-input"type="checkbox" name="permission[articles_view]" id="permissionArticles1" value="1">
													<label for="permissionArticles1" class="custom-control-label">Listar</label>
												</div>
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input"type="checkbox" name="permission[articles_create]" id="permissionArticles2" value="1">
													<label for="permissionArticles2" class="custom-control-label">Criar</label>
												</div>
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input"type="checkbox" name="permission[articles_update]" id="permissionArticles3" value="1">
													<label for="permissionArticles3" class="custom-control-label">Editar</label>
												</div>
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input"type="checkbox" name="permission[articles_delete]" id="permissionArticles4" value="1">
													<label for="permissionArticles4" class="custom-control-label">Excluir</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- /.card-body -->
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12 d-flex justify-content-end">
							<button type="submit" class="btn btn-success">Cadastrar</button>
						</div>
					</div>
				</form>
			  </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
