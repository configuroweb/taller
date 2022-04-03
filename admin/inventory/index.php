<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Inventario</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="add_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Agregar Existencias</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<div class="container-fluid">
				<table class="table table-bordered table-stripped">
					<colgroup>
						<col width="10%">
						<col width="15%">
						<col width="25%">
						<col width="25%">
						<col width="10%">
						<col width="15%">
					</colgroup>
					<thead>
						<tr>
							<th>#</th>
							<th>Fecha Creación</th>
							<th>Marca</th>
							<th>Proudcto</th>
							<th>Cantidad</th>
							<th>Acción</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						$qry = $conn->query("SELECT p.*,b.name as brand from `product_list` p inner join brand_list b on p.brand_id = b.id where p.delete_flag = 0 order by (p.`name`) asc ");
						while ($row = $qry->fetch_assoc()) :
							$row['stocks'] = $conn->query("SELECT SUM(quantity) FROM stock_list where product_id = '{$row['id']}'")->fetch_array()[0];
							$row['out'] = $conn->query("SELECT SUM(quantity) FROM order_items where product_id = '{$row['id']}' and order_id in (SELECT id FROM order_list where `status` != 5) ")->fetch_array()[0];
							$row['stocks'] = $row['stocks'] > 0 ? $row['stocks'] : 0;
							$row['out'] = $row['out'] > 0 ? $row['out'] : 0;
							$row['available'] = $row['stocks'] - $row['out'];
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
								<td><?php echo ucwords($row['brand']) ?></td>
								<td><?php echo ucwords($row['name']) ?></td>
								<td class="text-right"><?= number_format($row['available']) ?></td>
								<td align="center">
									<button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
										Acción
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<div class="dropdown-menu" role="menu">
										<a class="dropdown-item" href="?page=inventory/view_stock&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Ver</a>
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
		$('#add_new').click(function() {
			uni_modal("Agregar Nuevo Inventario", "inventory/manage_stock.php")
		})
		$('.delete_data').click(function() {
			_conf("¿Estás seguro de eliminar las existencias de este producto de forma permanente?", "delete_product", [$(this).attr('data-id')])
		})
		$('.table th, .table td').addClass("align-middle px-2 py-1")
		$('.table').dataTable();
		$('.table').dataTable();
	})

	function delete_product($id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=delete_product",
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