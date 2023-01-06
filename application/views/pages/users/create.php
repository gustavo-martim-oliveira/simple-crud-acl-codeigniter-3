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
					<h5 class="m-0">Criar usuário</h5>
				</div>
              </div>
              <div class="card-body">
  				<form method="post" action="<?= base_url('users/store') ?>">
  					<div class="row">
					  	<div class="col-md-6">
							<div class="form-group">
								<label for="name">Nome</label>
								<input type="text" class="form-control" id="name" name="name" placeholder="Nome" required value="<?=(isset($_SESSION['__formOld']['name']) ? $_SESSION['__formOld']['name'] : '')?>">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Nível do usuário</label>
								<select class="form-control select2" name="level" style="width: 100%;" required>
  									<?php
									foreach($roles as $role){
									?>

									<?php if($role->id == 1 && getRole()->id == 1 or $role->id != 1){ ?>
										<option value="<?=$role->id?>" <?=(isset($_SESSION['__formOld']['level']) && $_SESSION['__formOld']['level'] == $role->id ? 'selected' : '')?>><?=$role->title?></option>
									<?php }?>

									<?php
									}
									?>
									
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="login">Login</label>
								<input type="text" class="form-control" id="login" name="login" placeholder="Login" required value="<?=(isset($_SESSION['__formOld']['name']) ? $_SESSION['__formOld']['login'] : '')?>">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="Email" required value="<?=(isset($_SESSION['__formOld']['name']) ? $_SESSION['__formOld']['email'] : '')?>">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="password">Senha</label>
								<input type="password" class="form-control" id="password" name="password" placeholder="Senha" required value="<?=(isset($_SESSION['__formOld']['name']) ? $_SESSION['__formOld']['password'] : '')?>">
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
