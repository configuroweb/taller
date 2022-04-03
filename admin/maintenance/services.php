<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Servicios</h3>
		<div class="card-tools">
			<a href="?page=maintenance/manage_service" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Crear Nuevo</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<div class="container-fluid">
				<table class="table table-bordered table-stripped">
					<colgroup>
						<col width="5%">
						<col width="15%">
						<col width="20%">
						<col width="30%">
						<col width="15%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr>
							<th>#</th>
							<th>Fecha</th>
							<th>Nombre Servicio</th>
							<th>Descripción</th>
							<th>Estado</th>
							<th>Acción</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						$qry = $conn->query("SELECT * from `service_list` where delete_flag = 0 order by service asc ");
						while ($row = $qry->fetch_assoc()) :
							$row['description'] = strip_tags(html_entity_decode(stripslashes($row['description'])));
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
								<td><?php echo $row['service'] ?></td>
								<td>
									<p class="truncate-3 m-0 lh-1"><small><?php echo $row['description'] ?></small></p>
								</td>
								<td class="text-center">
									<?php if ($row['status'] == 1) : ?>
										<span class="badge badge-success">Activo</span>
									<?php else : ?>
										<span class="badge badge-danger">Inactivo</span>
									<?php endif; ?>
								</td>
								<td align="center">
									<button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
										Acción
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<div class="dropdown-menu" role="menu">
										<a class="dropdown-item" href="?page=maintenance/manage_service&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Editar</a>
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
			_conf("¿Estás seguro de eliminar este servicio de forma permanente?", "delete_service", [$(this).attr('data-id')])
		})
		$('.table').dataTable();
	})

	function delete_service($id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=delete_service",
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