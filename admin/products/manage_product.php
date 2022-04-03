<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
	$qry = $conn->query("SELECT * from `product_list` where id = '{$_GET['id']}' ");
	if ($qry->num_rows > 0) {
		foreach ($qry->fetch_assoc() as $k => $v) {
			$$k = stripslashes($v);
		}
	}
}
?>
<div class="card card-outline card-info rounded-0">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Actualizar " : "Crear " ?> Producto</h3>
	</div>
	<div class="card-body">
		<form action="" id="product-form">
			<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
			<div class="form-group">
				<label for="brand_id" class="control-label">Marca</label>
				<select name="brand_id" id="brand_id" class="custom-select select2">
					<option value="" <?= !isset($brand_id) ? "selected" : "" ?> disabled></option>
					<?php
					$brands = $conn->query("SELECT * FROM brand_list where delete_flag = 0 " . (isset($brand_id) ? " or id = '{$brand_id}'" : "") . " order by `name` asc ");
					while ($row = $brands->fetch_assoc()) :
					?>
						<option value="<?= $row['id'] ?>" <?= isset($brand_id) && $brand_id == $row['id'] ? "selected" : "" ?>><?= $row['name'] ?> <?= $row['delete_flag'] == 1 ? "<small>Eliminado</small>" : "" ?></option>
					<?php endwhile; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="category_id" class="control-label">Categoría</label>
				<select name="category_id" id="category_id" class="custom-select select2">
					<option value="" <?= !isset($category_id) ? "selected" : "" ?> disabled></option>
					<?php
					$categories = $conn->query("SELECT * FROM categories where delete_flag = 0 " . (isset($category_id) ? " or id = '{$category_id}'" : "") . " order by `category` asc ");
					while ($row = $categories->fetch_assoc()) :
					?>
						<option value="<?= $row['id'] ?>" <?= isset($category_id) && $category_id == $row['id'] ? "selected" : "" ?>><?= $row['category'] ?> <?= $row['delete_flag'] == 1 ? "<small>Eliminado</small>" : "" ?></option>
					<?php endwhile; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="name" class="control-label">Nombre</label>
				<input name="name" id="name" type="text" class="form-control rounded-0" value="<?php echo isset($name) ? $name : ''; ?>" required>
			</div>
			<div class="form-group">
				<label for="models" class="control-label">Modelo: </small></label>
				<input name="models" id="models" type="text" class="form-control rounded-0" value="<?php echo isset($models) ? $models : ''; ?>" required>
			</div>
			<div class="form-group">
				<label for="description" class="control-label">Descripción</label>
				<textarea name="description" id="description" type="text" class="form-control rounded-0 summernote" required><?php echo isset($description) ? $description : ''; ?></textarea>
			</div>
			<div class="form-group">
				<label for="price" class="control-label">Precio</label>
				<input name="price" id="price" type="number" class="form-control rounded-0 text-right" value="<?php echo isset($price) ? $price : 0; ?>" required>
			</div>
			<div class="form-group">
				<label for="status" class="control-label">Estado</label>
				<select name="status" id="status" class="custom-select selevt">
					<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Activo</option>
					<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactivo</option>
				</select>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<label for="" class="control-label">Imagen de Producto</label>
						<div class="custom-file">
							<input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
							<label class="custom-file-label" for="customFile">Examinar</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="d-flex justify-content-center">
							<img src="<?php echo validate_image(isset($image_path) ? $image_path : "") ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
						</div>
					</div>
				</div>
			</div>

		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="product-form">Guardar</button>
		<a class="btn btn-flat btn-default" href="?page=products">Cancelar</a>
	</div>
</div>
<script>
	window.displayImg = function(input, _this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#cimg').attr('src', e.target.result);
				_this.siblings('.custom-file-label').html(input.files[0].name)
			}

			reader.readAsDataURL(input.files[0]);
		} else {
			$('#cimg').attr('src', "<?php echo validate_image(isset($image_path) ? $image_path : "") ?>");
			_this.siblings('.custom-file-label').html("Choose file")
		}
	}
	$(document).ready(function() {
		$('.select2').select2({
			width: '100%',
			placeholder: "Selecciona aquí"
		})
		$('#product-form').submit(function(e) {
			e.preventDefault();
			var _this = $(this)
			$('.err-msg').remove();
			start_loader();
			$.ajax({
				url: _base_url_ + "classes/Master.php?f=save_product",
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
						location.href = "./?page=products/view_product&id=" + resp.id;
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
</script>