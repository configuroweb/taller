<?php
if ($_settings->userdata('id') > 0 && $_settings->userdata('login_type') == 2) {
    $qry = $conn->query("SELECT * FROM `client_list` where id = '{$_settings->userdata('id')}'");
    if ($qry->num_rows > 0) {
        $res = $qry->fetch_array();
        foreach ($res as $k => $v) {
            if (!is_numeric($k)) {
                $$k = $v;
            }
        }
    } else {
        echo "<script> alert('You are not allowed to access this page. Unknown User ID.'); location.replace('./') </script>";
    }
} else {
    echo "<script> alert('You are not allowed to access this page.'); location.replace('./') </script>";
}
?>
<div class="content py-5 mt-3">
    <div class="container">
        <div class="card card-outline card-dark shadow rounded-0">
            <div class="card-header">
                <h4 class="card-title"><b>Administrar detalles/credenciales de la cuenta</b></h4>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <form id="register-frm" action="" method="post">
                        <input type="hidden" name="id" value="<?= isset($id) ? $id : "" ?>">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" name="firstname" id="firstname" placeholder="Ingresa Nombre" autofocus class="form-control form-control-sm form-control-border" value="<?= isset($firstname) ? $firstname : "" ?>" required>
                                <small class="ml-3">Nombre</small>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" name="middlename" id="middlename" placeholder="Segundo Nombre (opcional)" class="form-control form-control-sm form-control-border" value="<?= isset($middlename) ? $middlename : "" ?>">
                                <small class="ml-3">Segundo Nombre</small>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" name="lastname" id="lastname" placeholder="Ingresa tu Apellido" class="form-control form-control-sm form-control-border" required value="<?= isset($lastname) ? $lastname : "" ?>">
                                <small class="ml-3">Apellido</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <select name="gender" id="gender" class="custom-select custom-select-sm form-control-border" required>
                                    <option <?= isset($gender) && $gender == 'Male' ? "selected" : "" ?>>Male</option>
                                    <option <?= isset($gender) && $gender == 'Female' ? "selected" : "" ?>>Female</option>
                                </select>
                                <small class="ml-3">Género</small>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" name="contact" id="contact" placeholder="Ingresa tu número de móvil" class="form-control form-control-sm form-control-border" required value="<?= isset($contact) ? $contact : "" ?>">
                                <small class="ml-3">Móvil</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <small class="ml-3">Dirección</small>
                                <textarea name="address" id="address" rows="3" class="form-control form-control-sm rounded-0" placeholder="Ingresa tu dirección de pedidos"><?= isset($address) ? $address : "" ?></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="email" name="email" id="email" placeholder="tucorreo@cweb.com" class="form-control form-control-sm form-control-border" required value="<?= isset($email) ? $email : "" ?>">
                                <small class="ml-3">Correo</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <input type="password" name="password" id="password" placeholder="" class="form-control form-control-sm form-control-border">
                                    <div class="input-group-append border-bottom border-top-0 border-left-0 border-right-0">
                                        <span class="input-append-text text-sm"><i class="fa fa-eye-slash text-muted pass_type" data-type="password"></i></span>
                                    </div>
                                </div>
                                <small class="ml-3">Nueva Contraseña</small>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <input type="password" id="cpassword" placeholder="" class="form-control form-control-sm form-control-border">
                                    <div class="input-group-append border-bottom border-top-0 border-left-0 border-right-0">
                                        <span class="input-append-text text-sm"><i class="fa fa-eye-slash text-muted pass_type" data-type="password"></i></span>
                                    </div>
                                </div>
                                <small class="ml-3">Confirmar Nueva Contraseña</small>
                            </div>
                            <div class="col-12"><small class="text-muted"><em>Complete los campos de contraseña de arriba solo si desea actualizar su contraseña.</em></small></div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <input type="password" name="oldpassword" id="oldpassword" placeholder="" class="form-control form-control-sm form-control-border" required>
                                    <div class="input-group-append border-bottom border-top-0 border-left-0 border-right-0">
                                        <span class="input-append-text text-sm"><i class="fa fa-eye-slash text-muted pass_type" data-type="password"></i></span>
                                    </div>
                                </div>
                                <small class="ml-3">Contraseña Actual</small>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-8">
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-sm btn-flat btn-block">Actualizar Información</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('.pass_type').click(function() {
            var type = $(this).attr('data-type')
            if (type == 'password') {
                $(this).attr('data-type', 'text')
                $(this).closest('.input-group').find('input').attr('type', "text")
                $(this).removeClass("fa-eye-slash")
                $(this).addClass("fa-eye")
            } else {
                $(this).attr('data-type', 'password')
                $(this).closest('.input-group').find('input').attr('type', "password")
                $(this).removeClass("fa-eye")
                $(this).addClass("fa-eye-slash")
            }
        })
        $('#register-frm').submit(function(e) {
            e.preventDefault()
            var _this = $(this)
            $('.err-msg').remove();
            var el = $('<div>')
            el.hide()
            if ($('#password').val() != $('#cpassword').val()) {
                el.addClass('alert alert-danger err-msg').text('Password does not match.');
                _this.prepend(el)
                el.show('slow')
                return false;
            }
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Users.php?f=save_client",
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
                        el.addClass("alert alert-danger err-msg").text(resp.msg)
                        _this.prepend(el)
                        el.show('slow')
                    } else {
                        alert_toast("Ocurrió un error", 'error');
                        end_loader();
                        console.log(resp)
                    }
                    end_loader();
                    $('html, body').scrollTop(0)
                }
            })
        })
    })
</script>