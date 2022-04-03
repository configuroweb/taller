<style>
    .prod-cart-img{
        width:10em;
        height:10em;
        object-fit:scale-down;
        object-position: center center;
    }
</style>
<div class="content py-5 mt-3">
    <div class="container">
        <h3><b>My Shopping Cart</b></h3>
        <hr>
        <div class="card card-outline card-primary shadow rounded-0">
            <div class="w-100" id="cart-list">
                <?php 
                $total = 0;
                $cart = $conn->query("SELECT c.*,p.name, p.price, p.image_path,b.name as brand, cc.category FROM `cart_list` c inner join product_list p on c.product_id = p.id inner join brand_list b on p.brand_id = b.id inner join categories cc on p.category_id = cc.id where c.client_id = '{$_settings->userdata('id')}' order by p.name asc");
                while($row = $cart->fetch_assoc()):
                    $total += ($row['quantity'] * $row['price']);
                ?>
                <div class="d-flex align-items-center w-100 border cart-item" data-id="<?= $row['id'] ?>">
                    <div class="col-auto flex-grow-1 flex-shrink-1 px-1 py-1">
                        <div class="d-flex align-items-center w-100 ">
                            <div class="col-auto">
                                <img src="<?= validate_image($row['image_path']) ?>" alt="Product Image" class="img-thumbnail prod-cart-img">
                            </div>
                            <div class="col-auto flex-grow-1 flex-shrink-1">
                                <a href="./?p=products/view_product&id=<?= $row['product_id'] ?>" class="h4 text-muted">
                                    <p class="text-truncate-1 m-0"><?= $row['name'] ?></p>
                                </a>
                                <small><?= $row['brand'] ?></small><br>
                                <small><?= $row['category'] ?></small><br>
                                <div class="d-flex align-items-center w-100 mb-1">
                                    <div class="input-group " style="width:8em">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-sm btn-outline-secondary btn-minus" data-id='<?= $row['id'] ?>'><i class="fa fa-minus"></i></button>
                                        </div>
                                        <input type="text" value="<?= $row['quantity'] ?>" readonly class="form-control form-control-sm text-center">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-outline-secondary btn-plus" data-id='<?= $row['id'] ?>'><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <span class="ml-2">X <?= number_format($row['price'],2) ?></span>
                                </div>
                                <button class="btn btn-sm btn-flat btn-outline-danger btn-remove" data-id="<?= $row['id'] ?>"><i class="fa fa-times"></i> Remove</button>
                            </div>
                         </div>
                    </div>
                    <div class="col-auto text-right">
                        <h3><b><?= number_format($row['quantity'] * $row['price'],2) ?></b></h3>
                    </div>
                </div>
                <?php endwhile; ?>
                <?php if($cart->num_rows <= 0): ?>
                <div class="d-flex align-items-center w-100 border justify-content-center">
                    <div class="col-12 flex-grow-1 flex-shrink-1 px-1 py-1">
                           <small class="text-muted">No Data</small>
                    </div>
                </div>
                <?php endif; ?>
                <div class="d-flex align-items-center w-100 border">
                    <div class="col-auto flex-grow-1 flex-shrink-1 px-1 py-1">
                            <h3 class="text-center">TOTAL</h3>
                    </div>
                    <div class="col-auto text-right">
                        <h3><b><?= number_format($total,2) ?></b></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear-fix my-2"></div>
        <div class="text-right">
            <button class="btn btn-flat btn-sm btn-dark" type="button" id="checkout">Checkout</button>
        </div>
    </div>
</div>
<script>
    window.update_quantity = function($cart_id = 0, $quantity = ""){
        start_loader();
        $.ajax({
            url:_base_url_+'classes/master.php?f=update_cart_quantity',
            data:{cart_id : $cart_id, quantity : $quantity},
            method:'POST',
            dataType:'json',
            error:err=>{
                console.error(err)
                alert_toast('An error occurred.','error')
                end_loader()
            },
            success:function(resp){
                if(resp.status == 'success'){
                    location.reload()
                }else if(!!resp.msg){
                    alert_toast(resp.msg,'error')
                }else{
                    alert_toast('An error occurred.','error')
                }
                end_loader();
            }
        })
    }
    $(function(){
        $('.btn-minus').click(function(){
            update_quantity($(this).attr('data-id'),"- 1")
        })
        $('.btn-plus').click(function(){
            update_quantity($(this).attr('data-id'),"+ 1")
        })
        $('.btn-remove').click(function(){
            _conf("Are you sure to remove this product from cart list?","remove_from_cart",[$(this).attr('data-id')])
        })
        $('#checkout').click(function(){
            if($('#cart-list .cart-item').length > 0){
                location.href="./?p=place_order"
            }else{
                alert_toast('Shopping cart is empty.','error')
            }
        })
    })
    function remove_from_cart($id){
        start_loader();
        $.ajax({
            url:_base_url_+'classes/master.php?f=remove_from_cart',
            data:{cart_id : $id},
            method:'POST',
            dataType:'json',
            error:err=>{
                console.error(err)
                alert_toast('An error occurred.','error')
                end_loader()
            },
            success:function(resp){
                if(resp.status == 'success'){
                    location.reload()
                }else if(!!resp.msg){
                    alert_toast(resp.msg,'error')
                }else{
                    alert_toast('An error occurred.','error')
                }
                end_loader();
            }
        })
    }
</script>