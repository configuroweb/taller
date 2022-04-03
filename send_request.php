<?php
require_once('config.php');
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
        <input type="hidden" name="id">
        <div class="col-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="vehicle_type" class="control-label">Tipo de Dispositivo Electrónico</label>
                        <input type="text" name="vehicle_type" id="vehicle_type" class="form-control form-control-sm rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="vehicle_name" class="control-label">Nombre del Dispositivo</label>
                        <input type="text" name="vehicle_name" id="vehicle_name" class="form-control form-control-sm rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="vehicle_registration_number" class="control-label">Número Registro Dispositivo</label>
                        <input type="text" name="vehicle_registration_number" id="vehicle_registration_number" class="form-control form-control-sm rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="vehicle_model" class="control-label">Modelo Dispositivo</label>
                        <input type="text" name="vehicle_model" id="vehicle_model" class="form-control form-control-sm rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="service_id" class="control-label">Servicios</label>
                        <select name="service_id[]" id="service_id" class="form-select form-select-sm select2 rounded-0" multiple required>
                            <option disabled></option>
                            <?php
                            $service = $conn->query("SELECT * FROM `service_list` where status = 1 and delete_flag = 0 order by `service` asc");
                            while ($row = $service->fetch_assoc()) :
                            ?>
                                <option value="<?php echo $row['id'] ?>"><?php echo  $row['service'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="service_type" class="control-label">Forma de Entrega</label>
                        <select name="service_type" id="service_type" class="form-select form-select-sm select2 rounded-0" required>
                            <option>Dejarlo</option>
                            <option>Recogerlo</option>
                        </select>
                    </div>
                    <div class="form-group" style="display:none">
                        <label for="pickup_address" class="control-label">Dirección de Entrega</label>
                        <textarea rows="3" name="pickup_address" id="pickup_address" class="form-control form-control-sm rounded-0" style="resize:none"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-100 d-flex justify-content-end mx-2">
            <div class="col-auto">
                <button class="btn btn-primary btn-sm rounded-0">Enviar Solicitud</button>
                <button class="btn btn-dark btn-sm rounded-0" type="button" data-dismiss="modal">Cerrar</button>
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
                url: 'classes/Master.php?f=save_request',
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
                        location.href = "./?p=my_services"
                    } else if (!!resp.msg) {
                        alert_toast(resp.msg, 'error')
                    } else {
                        alert_toast("Ocurrió un error", 'error');
                    }
                    end_loader()
                }
            })
        })
    })
</script>