<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Solicitudes de Servicio</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Nuevo Servicio</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<div class="container-fluid">
				<table class="table table-bordered table-stripped">
					<colgroup>
						<col width="5%">
						<col width="35%">
						<col width="25%">
						<col width="25%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr>
							<th>#</th>
							<th>Fecha Creación</th>
							<th>Cliente</th>
							<th>Servicio</th>
							<th>Estado</th>
							<th>Acción</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						$qry = $conn->query("SELECT s.*,concat(c.lastname,', ', c.firstname,' ',c.middlename) as fullname from service_requests s inner join client_list c on s.client_id = c.id order by unix_timestamp(s.date_created) desc");
						while ($row = $qry->fetch_assoc()) :
							$sids = $conn->query("SELECT meta_value FROM request_meta where request_id = '{$row['id']}' and meta_field = 'service_id'")->fetch_assoc()['meta_value'];
							$services  = $conn->query("SELECT * FROM service_list where id in ({$sids}) ");
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
								<td><?php echo ucwords($row['fullname']) ?></td>
								<td>
									<p class="m-0 truncate-3">
										<?php
										$s = 0;
										while ($srow = $services->fetch_assoc()) {
											$s++;
											if ($s != 1) echo ", ";
											echo $srow['service'];
										}
										?>
									</p>
								</td>
								<td class="text-center">
									<?php if ($row['status'] == 1) : ?>
										<span class="badge badge-primary rounded-pill px-3">Confirmado</span>
									<?php elseif ($row['status'] == 2) : ?>
										<span class="badge badge-warning rounded-pill px-3">En Progreso</span>
									<?php elseif ($row['status'] == 3) : ?>
										<span class="badge badge-success rounded-pill px-3">Finalizado</span>
									<?php elseif ($row['status'] == 4) : ?>
										<span class="badge badge-danger rounded-pill px-3">Cancelado</span>
									<?php else : ?>
										<span class="badge badge-secondary rounded-pill px-3">Pendiente</span>
									<?php endif; ?>
								</td>
								<td align="center">
									<button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
										Acción
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<div class="dropdown-menu" role="menu">
										<a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-primary"></span> Ver</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Editar</a>
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
			_conf("¿Estás seguro de eliminar esta solicitud de servicio de forma permanente?", "delete_service_request", [$(this).attr('data-id')])
		})
		$('.view_data').click(function() {
			uni_modal("Información Solicitud de Servicio", "service_requests/view_request.php?id=" + $(this).attr('data-id'), 'large')
		})
		$('#create_new').click(function() {
			uni_modal("Información Solicitud de Servicio", "service_requests/manage_request.php", 'large')
		})
		$('.edit_data').click(function() {
			uni_modal("Información Solicitud de Servicio", "service_requests/manage_request.php?id=" + $(this).attr('data-id'), 'large')
		})
		$('.table').dataTable();
	})

	function delete_service_request($id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=delete_request",
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