<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Clientes</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<div class="container-fluid">
				<table class="table table-bordered table-stripped">
					<colgroup>
						<col width="5%">
						<col width="15%">
						<col width="30%">
						<col width="25%">
						<col width="10%">
						<col width="15%">
					</colgroup>
					<thead>
						<tr>
							<th>#</th>
							<th>Fecha Creación</th>
							<th>Nombre</th>
							<th>Contacto</th>
							<th>Estado</th>
							<th>Acción</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						$qry = $conn->query("SELECT *,concat(lastname, ', ', firstname,' ',middlename) as fullname from `client_list` where delete_flag= 0 order by concat(lastname, ', ', firstname,' ',middlename) asc ");
						while ($row = $qry->fetch_assoc()) :
							foreach ($row as $k => $v) {
								$row[$k] = trim(stripslashes($v));
							}
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
								<td><?php echo ucwords($row['fullname']) ?></td>
								<td>
									<p class="m-0 lh-1">
										<?php echo $row['contact'] ?> <br>
										<?php echo $row['email'] ?>
									</p>
								</td>
								<td class="text-center">
									<?php if ($row['status'] == 1) : ?>
										<span class="badge badge-success rounded-pill px-3">Activo</span>
									<?php else : ?>
										<span class="badge badge-danger rounded-pill px-3">Inactivo</span>
									<?php endif; ?>
								</td>
								<td align="center">
									<button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
										Acción
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<div class="dropdown-menu" role="menu">
										<a class="dropdown-item" href="?page=clients/manage_client&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Editar</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Eliminar</a>
									</div>
								</td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('.delete_data').click(function() {
			_conf("¿Estás seguro de eliminar este cliente de forma permanente?", "delete_client", [$(this).attr('data-id')])
		})
		$('.table').dataTable();
	})

	function delete_client($id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Users.php?f=delete_client",
			method: "POST",
			data: {
				id: $id
			},
			dataType: "json",
			error: err => {
				console.log(err)
				alert_toast("Ocurrió un error", 'error');
				end_loader();
			},
			success: function(resp) {
				if (typeof resp == 'object' && resp.status == 'success') {
					location.reload();
				} else {
					alert_toast("Ocurrió un error", 'error');
					end_loader();
				}
			}
		})
	}
</script>