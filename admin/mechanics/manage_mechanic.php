<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
	$qry = $conn->query("SELECT * from `mechanics_list` where id = '{$_GET['id']}' ");
	if ($qry->num_rows > 0) {
		foreach ($qry->fetch_assoc() as $k => $v) {
			$$k = stripslashes($v);
		}
	}
}
?>
<div class="card card-outline card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Actualiza " : "Crear " ?> Técnico</h3>
	</div>
	<div class="card-body">
		<form action="" id="mechanic-form">
			<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
			<div class="form-group">
				<label for="name" class="control-label">Nombre Completo</label>
				<input name="name" id="name" type="text" class="form-control rounded-0" value="<?php echo isset($name) ? $name : ''; ?>" required>
			</div>
			<div class="form-group">
				<label for="contact" class="control-label">Contacto</label>
				<input name="contact" id="contact" type="text" class="form-control rounded-0" value="<?php echo isset($contact) ? $contact : ''; ?>" required>
			</div>
			<div class="form-group">
				<label for="email" class="control-label">Correo</label>
				<input name="email" id="email" type="email" class="form-control rounded-0" value="<?php echo isset($email) ? $email : ''; ?>" required>
			</div>
			<div class="form-group">
				<label for="status" class="control-label">Estado</label>
				<select name="status" id="status" class="custom-select selevt">
					<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Activo</option>
					<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactivo</option>
				</select>
			</div>
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="mechanic-form">Guardar</button>
		<a class="btn btn-flat btn-default" href="?page=mechanics">Cancelar</a>
	</div>
</div>
<script>
	$(document).ready(function() {

		$('#mechanic-form').submit(function(e) {
			e.preventDefault();
			var _this = $(this)
			$('.err-msg').remove();
			start_loader();
			$.ajax({
				url: _base_url_ + "classes/Master.php?f=save_mechanic",
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
						location.href = "./?page=mechanics";
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