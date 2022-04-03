<div class="content py-5 mt-3">
    <div class="container">
        <div class="card card-outline card-dark shadow rounded-0">
            <div class="card-header">
                <h4 class="card-title">Place Order</h4>
            </div>
            <div class="card-body">
                <form action="" id="place_order">
                    <div class="form-group">
                        <label for="delivery_address" class="control-label">Delivery Address</label>
                        <textarea name="delivery_address" id="delivery_address" class="form-control form-control-sm rounded-0" rows="4"><?= $_settings->userdata('address') ?></textarea>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-flat btn-primary">Place Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#place_order').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=place_order",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.replace('./?p=my_orders');
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})
    })
</script>