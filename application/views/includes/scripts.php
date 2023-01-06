</div>
<script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/js/adminlte.min.js') ?>"></script>

<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jszip/jszip.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/pdfmake/pdfmake.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/pdfmake/vfs_fonts.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js')?>"></script>
<script src="<?= base_url('assets/plugins/select2/js/select2.full.min.js') ?>"></script>


<?php
if(isset($_SESSION['error'])):
?>
<script>
 Swal.fire('Atenção', "<?=$_SESSION['error']?>", 'error');
</script>
<?php
endif;
?>

<?php
if(isset($_SESSION['success'])):
?>
<script>
 Swal.fire('Atenção', "<?=$_SESSION['success']?>", 'success');
</script>
<?php
endif;
?>


<script>
	$(function () {

		$("#users_list_table").DataTable({
			"responsive": true, "lengthChange": false, "autoWidth": false,
			"buttons": ["copy", "csv", "excel", "pdf", "print"]
		}).buttons().container().appendTo('#users_list_table_wrapper .col-md-6:eq(0)');

		$('#users_list_table').on('submit', 'form[data-form="confirm"]', function(e){
			e.preventDefault();
			let form = $(this);
			Swal.fire({
				title: 'Atenção!',
				html: 'Tem certeza que deseja excluir este registro?',
				inverse: true,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Sim, Deletar!',
				cancelButtonText: 'Cancelar'
			}).then((result) => {
				if (result.isConfirmed) {
					form.removeAttr('data-form').queue(function(){
						form.submit();
						this.dequeue();
					});
				}
			})
		})
		
		$('.select2').select2();
	})
</script>
</body>
</html>
