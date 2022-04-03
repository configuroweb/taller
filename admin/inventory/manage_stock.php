<?php
require_once('./../../config.php');
if (isset($_GET['pid']) && !empty($_GET['pid']))
	$product_id = $_GET['pid'];
if (isset($_GET['id']) && $_GET['id'] > 0) {
	$qry = $conn->query("SELECT * from `stock_list` where id = '{$_GET['id']}' ");
	if ($qry->num_rows > 0) {
		foreach ($qry->fetch_assoc() as $k => $v) {
			$$k = stripslashes($v);
		}
	}
}
?>
<div class="container-fluid">
	<form action="" id="stock-form">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<?php if (isset($product_id)) : ?>
			<input type="hidden" name="product_id" value="<?php echo $product_id ?>">
		<?php else : ?>
			<div class="form-group">
				<label for="product_id" class="control-label">Producto</label>
				<select name="product_id" id="product_id" class="custom-select select2">
					<option value="" <?= !isset($product_id) ? "selected" : "" ?> disabled></option>
					<?php
					$product = $conn->query("SELECT p.*,b.name as brand from `product_list` p inner join brand_list b on p.brand_id = b.id where p.delete_flag = 0 " . (isset($product_id) ? " or p.id = '{$product_id}'" : "") . " order by (p.`name`) asc ");
					while ($row = $product->fetch_assoc()) :
					?>
						<option value="<?= $row['id'] ?>" <?= isset($product_id) && $product_id == 1 ? "Seleccionado" : "" ?>><?= $row['brand'] . ' - ' . $row['name'] ?> <?= $row['status'] == 0 ? "<small>(Inactivo)</small>" : "" ?> <?= $row['delete_flag'] == 1 ? "<small>(Eliminado)</small>" : "" ?></option>
					<?php endwhile; ?>
				</select>
			</div>
		<?php endif; ?>
		<div class="form-group">
			<label for="quantity" class="control-label">Cantidad</label>
			<input name="quantity" id="quantity" type="number" min="1" class="form-control rounded-0 text-right" value="<?php echo isset($quantity) ? $quantity : 1; ?>" required>
		</div>

	</form>
</div>
<script>
	$(document).ready(function() {
		$('#uni_modal').on('shown.bs.modal', function() {
			$('.select2').select2({
				width: '100%',
				placeholder: "Seleccionar",
				dropdownParent: $('#uni_modal')
			})
			$('.summernote').summernote({
				height: 200,
				toolbar: [
					['style', ['style']],
					['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
					['fontname', ['fontname']],
					['fontsize', ['fontsize']],
					['color', ['color']],
					['para', ['ol', 'ul', 'paragraph', 'height']],
					['table', ['table']],
					['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
				]
			})
		})

		$('#stock-form').submit(function(e) {
			e.preventDefault();
			var _this = $(this)
			$('.err-msg').remove();
			start_loader();
			$.ajax({
				url: _base_url_ + "classes/Master.php?f=save_stock",
				data: new FormData($(this)[0]),
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				type: 'POST',
				dataType: 'json',
				error: err => {
					console.log(err)
					alert_toast("Ocurrió un error", 'error');
					end_loader();
				},
				success: function(resp) {
					if (typeof resp == 'object' && resp.status == 'success') {
						location.reload();
					} else if (resp.status == 'failed' && !!resp.msg) {
						var el = $('<div>')
						el.addClass("alert alert-danger err-msg").text(resp.msg)
						_this.prepend(el)
						el.show('slow')
						$("html, body").animate({
							scrollTop: _this.closest('.card').offset().top
						}, "fast");
						end_loader()
					} else {
						alert_toast("Ocurrió un error", 'error');
						end_loader();
						console.log(resp)
					}
				}
			})
		})


	})
</script>