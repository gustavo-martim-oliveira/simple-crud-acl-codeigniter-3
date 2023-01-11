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
					<h5 class="m-0">Criar categoria</h5>
				</div>
              </div>
              <div class="card-body">
  				<form method="post" action="<?= base_url('categories/store') ?>">
  					<div class="row">
					  	<div class="col-md-6">
							<div class="form-group">
								<label for="title">Título</label>
								<input type="text" class="form-control" id="title" name="title" placeholder="Título" required value="<?=(isset($_SESSION['__formOld']['title']) ? $_SESSION['__formOld']['title'] : '')?>">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Status</label>
								<select class="form-control users_active_select" name="status" style="width: 100%;" required>
									<option value="1" <?=(isset($_SESSION['__formOld']['status']) && $_SESSION['__formOld']['status'] == 1 ? 'selected' : '')?>>Ativo</option>
									<option value="0" <?=(isset($_SESSION['__formOld']['status']) && $_SESSION['__formOld']['status'] == 0 ? 'selected' : '')?>>Inativo</option>
								</select>
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
