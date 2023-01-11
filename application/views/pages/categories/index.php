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
					<h5 class="m-0">Listagem de categorias</h5>
					<?php if(can('categories_create')){ ?>
					<a href="<?=base_url('categories/create')?>" class="btn btn-outline-info">Adicionar categoria</a>
					<?php } ?>
				</div>
              </div>
              <div class="card-body">
			  <table id="users_list_table" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Titulo</th>
						<th>Artigos</th>
						<th>Status</th>
						<th><i class="fas fa-cog"></i></th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($categories as $key => $category){
					?>
					<tr>
						<td><?=$category->title?></td>
						<td><?=$category->articles?></td>
						<td><?=$category->status == 1 ? 'Ativo' : 'Inativo'?></td>
						<td>
							<div class="btn-group">
								<!--edit user -->
								<?php
								if(can('categories_update')){
								?>
									<a href="<?=base_url('categories/edit/'.$category->id)?>" class="btn btn-icon btn-sm btn-info"><i class="fas fa-edit"></i></a>
								<?php
								}
								?>
							
								<!-- delete user -->
								<?php
								if(can('categories_delete')){
								?>
									<form method="post" action="<?=base_url('categories/destroy/' . $category->id)?>" data-form="confirm">
										<button type="submit" class="btn btn-icon btn-sm btn-danger"><i class="fas fa-trash"></i></button>
									</form>
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


