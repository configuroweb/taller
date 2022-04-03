<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT p.*, b.name as brand,c.category from `product_list` p inner join brand_list b on p.brand_id = b.id inner join categories c on p.category_id = c.id where p.id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = stripslashes($v);
        }
        $stocks = $conn->query("SELECT SUM(quantity) FROM stock_list where product_id = '$id'")->fetch_array()[0];
        $out = $conn->query("SELECT SUM(quantity) FROM order_items where product_id = '{$id}' and order_id in (SELECT id FROM order_list where `status` != 5) ")->fetch_array()[0];
        $stocks = $stocks > 0 ? $stocks : 0;
        $out = $out > 0 ? $out : 0;
        $available = $stocks - $out;
    } else {
        echo "<script> alert('Unkown Product ID!'); location.replace('./?page=products');</script>";
    }
} else {
    echo "<script> alert('Product ID is required!'); location.replace('./?page=products');</script>";
}
?>
<style>
    .product-img {
        width: 20em;
        height: 17em;
        object-fit: scale-down;
        object-position: center center;
    }
</style>
<div class="content py-5 mt-3">
    <div class="container">
        <div class="card card-outline rounded-0 card-primary shadow">
            <div class="card-header">
                <h4 class="card-title">Información del Producto</h4>
                <div class="card-tools">
                    <a class="btn btn-default border btn-sm btn-flat" href="javascript:void(0)" id="add_to_cart"><i class="fa fa-cart-plus"></i> Agregar al Carrito</a>
                </div>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <img src="<?= validate_image(isset($image_path) ? $image_path : "") ?>" alt="Product Image <?= isset($name) ? $name : "" ?>" class="img-thumbnail product-img">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <small class="mx-2 text-muted">Marca</small>
                            <div class="pl-4"><?= isset($brand) ? $brand : '' ?></div>
                        </div>
                        <div class="col-md-6">
                            <small class="mx-2 text-muted">Categoría</small>
                            <div class="pl-4"><?= isset($category) ? $category : '' ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <small class="mx-2 text-muted">Modelo</small>
                            <div class="pl-4"><?= isset($models) ? $models : '' ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <small class="mx-2 text-muted">Nombre</small>
                            <div class="pl-4"><?= isset($name) ? $name : '' ?></div>
                        </div>
                        <div class="col-md-6">
                            <small class="mx-2 text-muted">Precio</small>
                            <div class="pl-4"><?= isset($price) ? number_format($price, 2) : '' ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <small class="mx-2 text-muted">Unidades Disponibles</small>
                            <div class="pl-4"><?= isset($available) ? number_format($available) : '' ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <small class="mx-2 text-muted">Descripción</small>
                            <div class="pl-4"><?= isset($description) ? html_entity_decode($description) : '' ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <small class="mx-2 text-muted">Estado</small>
                            <div class="pl-4">
                                <?php if (isset($status)) : ?>
                                    <?php if ($status == 1) : ?>
                                        <span class="badge badge-warning px-3 rounded-pill">Activo</span>
                                    <?php else : ?>
                                        <span class="badge badge-danger px-3 rounded-pill">Inactivo</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('#add_to_cart').click(function() {
            if ("<?= $_settings->userdata('id') > 0 && $_settings->userdata('login_type') == 2 ?>" == 1) {
                if ('<?= $available > 0 ?>' == 1) {
                    start_loader()
                    $.ajax({
                        url: _base_url_ + "classes/Master.php?f=save_to_cart",
                        method: 'POST',
                        data: {
                            product_id: '<?= isset($id) ? $id : "" ?>',
                            quantity: 1
                        },
                        dataType: 'json',
                        error: err => {
                            console.error(err)
                            alert_toast("Ocurrió un error", "error")
                            end_loader();
                        },
                        success: function(resp) {
                            if (resp.status == 'success') {
                                update_cart_count(resp.cart_count);
                                alert_toast(" Producto añadido al carrito", 'success')
                            } else if (!!resp.msg) {
                                alert_toast(resp.msg, 'error')
                            } else {
                                alert_toast("Ocurrió un error", "error")
                            }
                            end_loader();
                        }
                    })
                }
            } else {
                alert_toast(" Debes loguearte primero", 'warning')
            }
        })
    })
</script>