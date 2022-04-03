<?php
require_once('./../../config.php');
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT s.*,cc.category,concat(c.lastname,', ', c.firstname,' ',c.middlename) as fullname,c.email,c.contact, c.address FROM `service_requests` s inner join `categories` cc inner join client_list c on s.client_id = c.id where s.id = '{$_GET['id']}' ");
    foreach ($qry->fetch_array() as $k => $v) {
        $$k = $v;
    }
    $meta = $conn->query("SELECT * FROM `request_meta` where request_id = '{$id}'");
    while ($row = $meta->fetch_assoc()) {
        ${$row['meta_field']} = $row['meta_value'];
    }
}
?>
<style>
    #uni_modal .modal-footer {
        display: none
    }

    span.select2-selection.select2-selection--single,
    span.select2-selection.select2-selection--multiple {
        padding: 0.25rem 0.5rem;
        min-height: calc(1.5em + 0.5rem + 2px);
        height: auto !important;
        max-height: calc(3.5em + 0.5rem + 2px);
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0;
    }
</style>
<div class="container-fluid">
    <form action="" id="request_form">
        <input type="hidden" name="id" value="<?php echo isset($id) ?  $id : "" ?>">
        <input type="hidden" name="client_id" value="<?php echo isset($client_id) ?  $client_id : "" ?>">
        <div class="col-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="vehicle_type" class="control-label">Tipo de Dispositivo</label>
                        <input type="text" name="vehicle_type" id="vehicle_type" class="form-control form-control-sm rounded-0" value="<?php echo isset($vehicle_type) ? $vehicle_type : "" ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="owner_name" class="control-label">Nombre del Dueño</label>
                        <input type="text" name="" id="owner_name" class="form-control form-control-sm rounded-0" value="<?php echo isset($fullname) ? $fullname : "" ?>">
                    </div>
                    <div class="form-group">
                        <label for="contact" class="control-label">Móvil del Dueño</label>
                        <input type="text" name="" id="contact" class="form-control form-control-sm rounded-0" value="<?php echo isset($contact) ? $contact : "" ?>">
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Correo del Dueño</label>
                        <input type="email" name="" id="email" class="form-control form-control-sm rounded-0" value="<?php echo isset($email) ? $email : "" ?>">
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Dirección</label>
                        <textarea rows="3" name="" id="address" class="form-control form-control-sm rounded-0" style="resize:none"><?php echo isset($address) ? $address : "" ?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="vehicle_name" class="control-label">Nombre Dispositivo</label>
                        <input type="text" name="vehicle_name" id="vehicle_name" class="form-control form-control-sm rounded-0" value="<?php echo isset($vehicle_name) ? $vehicle_name : "" ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="vehicle_registration_number" class="control-label">Registro Dispositivo</label>
                        <input type="text" name="vehicle_registration_number" id="vehicle_registration_number" class="form-control form-control-sm rounded-0" value="<?php echo isset($vehicle_registration_number) ? $vehicle_registration_number : "" ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="vehicle_model" class="control-label">Modelo Dispositivo</label>
                        <input type="text" name="vehicle_model" id="vehicle_model" class="form-control form-control-sm rounded-0" value="<?php echo isset($vehicle_model) ? $vehicle_model : "" ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="service_id" class="control-label">Servicios</label>
                        <select name="service_id[]" id="service_id" class="form-select form-select-sm select2 rounded-0" multiple required>
                            <option disabled></option>
                            <?php
                            $service = $conn->query("SELECT * FROM `service_list` where status = 1 order by `service` asc");
                            while ($row = $service->fetch_assoc()) :
                            ?>
                                <option value="<?php echo $row['id'] ?>" <?php echo isset($service_id) && in_array($row['id'], explode(",", $service_id)) ? "selected" : '' ?>><?php echo  $row['service'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="service_type" class="control-label">Modo Servicio</label>
                        <select name="service_type" id="service_type" class="form-select form-select-sm select2 rounded-0" required>
                            <option <?php echo isset($service_type) && $service_type == 'Drop Off' ? "selected" : '' ?>>Dejarlo</option>
                            <option <?php echo isset($service_type) && $service_type == 'Pick Up' ? "selected" : '' ?>>Recogerlo</option>
                        </select>
                    </div>
                    <div class="form-group" <?php echo isset($service_type) && $service_type == 'Drop Off' ? 'style="display:none"' : '' ?>>
                        <label for="pickup_address" class="control-label">Dirección de Entrega</label>
                        <textarea rows="3" name="pickup_address" id="pickup_address" class="form-control form-control-sm rounded-0" style="resize:none"><?php echo isset($pickup_address) ? $pickup_address : "" ?></textarea>
                    </div>
                </div>
            </div>
            <hr class="border-light">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group " id="mechanic-holder">
                        <label for="mechanic_id" class="control-label">Asignado a</label>
                        <select name="mechanic_id" id="mechanic_id" class="form-select form-select-sm rounded-0" required>
                            <option disabled <?php echo !isset($mechenic_id) || (isset($mechanic_id) && empty($mechanic_id)) ? "selected" : "" ?>></option>
                            <?php
                            $mechanic = $conn->query("SELECT * FROM `mechanics_list` where status = 1 order by `name` asc");
                            while ($row = $mechanic->fetch_assoc()) :
                            ?>
                                <option value="<?php echo $row['id'] ?>" <?php echo isset($mechanic_id) && in_array($row['id'], explode(",", $mechanic_id)) ? "selected" : '' ?>><?php echo  $row['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status" class="control-label">Estado</label>
                        <select name="status" id="status" class="custom-select custom-select-sm rounded-0" required>
                            <option value="0" <?php echo isset($status) && $status == 0 ? "selected" : '' ?>>Pendiente</option>
                            <option value="1" <?php echo isset($status) && $status == 1 ? "selected" : '' ?>>Confirmado</option>
                            <option value="2" <?php echo isset($status) && $status == 2 ? "selected" : '' ?>>En-Progreso</option>
                            <option value="3" <?php echo isset($status) && $status == 3 ? "selected" : '' ?>>Finalizado</option>
                            <option value="4" <?php echo isset($status) && $status == 4 ? "selected" : '' ?>>Cancelado</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-100 d-flex justify-content-end mx-2">
            <div class="col-auto">
                <button class="btn btn-primary btn-sm rounded-0">Guardar Servicio</button>
                <button class="btn btn-light btn-sm rounded-0" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>
<script>
    $(function() {
        $('.select2').select2({
            placeholder: "Selecciona aquí",
            dropdownParent: $('#uni_modal')
        })
        $('#mechanic_id').select2({
            placeholder: "Selecciona aquí",
            dropdownParent: $('#mechanic-holder')
        })
        $('#service_type').change(function() {
            var type = $(this).val().toLowerCase()
            if (type == 'pick up') {
                $('#pickup_address').parent().show()
                $('#pickup_address').attr('required', true)
            } else {
                $('#pickup_address').parent().hide()
                $('#pickup_address').attr('required', false)
            }

        })
        $('#request_form').submit(function(e) {
            e.preventDefault()
            start_loader();
            $.ajax({
                url: _base_url_ + 'classes/Master.php?f=save_request',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                error: err => {
                    console.log(err)
                    alert_toast("Ocurrió un error", 'error');
                    end_loader()
                },
                success: function(resp) {
                    end_loader()
                    if (resp.status == 'success') {
                        alert_toast("Datos guardado exitósamente", 'success');
                        setTimeout(() => {
                            uni_modal("Detalles de la solicitud de servicio", "service_requests/view_request.php?id=" + resp.id, 'large')
                            $('#uni_modal').on('hidden.bs.modal', function() {
                                location.reload()
                            })
                        }, 200);
                    } else {
                        alert_toast("Ocurrió un error", 'error');
                    }
                }
            })
        })
    })
</script>