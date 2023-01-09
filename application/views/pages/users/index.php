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
					<h5 class="m-0">Listagem de usuários</h5>
					<?php if(can('users_create')){ ?>
					<a href="<?=base_url('users/create')?>" class="btn btn-outline-info">Adicionar usuário</a>
					<?php } ?>
				</div>
              </div>
              <div class="card-body">
			  <table id="users_list_table" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Nome</th>
						<th>Email</th>
						<th>Login</th>
						<th>Permissão</th>
						<th>Status</th>
						<th>Criado em</th>
						<th><i class="fas fa-cog"></i></th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($users as $key => $user){
					?>
					<tr>
						<td><?=$user->name?></td>
						<td><?=$user->email?></td>
						<td><?=$user->login?></td>
						<td><?=getRole($user->id)?->title ?? 'Permissão não atribuída'?></td>
						<td><?=$user->status == 1 ? 'Ativo' : 'Inativo'?></td>
						<td><?=date('d/m/Y H:i:s', strtotime($user->created_at))?></td>
						<td>
							<div class="btn-group">
								<!--edit user -->
								<?php
								if(can('users_update')){
								?>
									<a href="<?=base_url('users/edit/'.$user->id)?>" class="btn btn-icon btn-sm btn-info"><i class="fas fa-edit"></i></a>
								<?php
								}
								?>
							
								<!-- delete user -->
								<?php
								if(auth_id() != $user->id){
								?>
									<?php
									if(can('users_delete')){
									?>
										<form method="post" action="<?=base_url('users/destroy/' . $user->id)?>" data-form="confirm">
											<button type="submit" class="btn btn-icon btn-sm btn-danger"><i class="fas fa-trash"></i></button>
										</form>
									<?php
									}
									?>
								<?php
								}
								?>
							</div>
						</td>
					</tr>
					<?php 
						} 
					?>
                  </tbody>
                </table>
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


