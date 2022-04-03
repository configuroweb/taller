<div class="content py-5 mt-3">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">Marcas en Nuestra Tienda</h3>
                <hr class="bg-primary opacity-100">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="search" id="search" class="form-control" placeholder="Búsqueda de Marca" aria-label="Search brand Here" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <span class="input-group-text bg-warning" id="basic-addon2"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
                <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-xl-3 justify-content-center" id="brand_list">
                    <?php
                    $brands = $conn->query("SELECT * FROM `brand_list` where status = 1 and delete_flag = 0 order by `name`");
                    while ($row = $brands->fetch_assoc()) :
                    ?>
                        <div class="col brand-item">
                            <div class="card rounded-0 shadow">
                                <div class="brand-img-holder overflow-hidden position-relative bg-gradient-dark">
                                    <img src="<?= validate_image($row['image_path']) ?>" alt="Brand Image" class="img-top" />
                                </div>
                                <div class="card-body">
                                    <h3 class="card-title text-center w-100"><?= $row['name'] ?></h3>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div id="noResult" style="display:none" class="text-center"><b>Sin resultados</b></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('#search').on('input', function() {
            var _search = $(this).val().toLowerCase().trim()
            $('#brand_list .brand-item').each(function() {
                var _text = $(this).text().toLowerCase().trim()
                _text = _text.replace(/\s+/g, ' ')
                console.log(_text)
                if ((_text).includes(_search) == true) {
                    $(this).toggle(true)
                } else {
                    $(this).toggle(false)
                }
            })
            if ($('#brand_list .brand-item:visible').length > 0) {
                $('#noResult').hide('slow')
            } else {
                $('#noResult').show('slow')
            }
        })
        $('#brand_list .brand-item').hover(function() {
            $(this).find('.callout').addClass('shadow')
        })
        $('#brand_list .view_brand').click(function() {
            uni_modal("brand Details", "view_brand.php?id=" + $(this).attr('data-id'), 'mid-large')
        })
        $('#send_request').click(function() {
            if ("<?= $_settings->userdata('id') > 0 && $_settings->userdata('login_type') == 2 ?>" == 1)
                uni_modal("Fill the brand Request Form", "send_request.php", 'mid-large');
            else
                alert_toast(" Loguéate primero.", "warning");
        })

    })
    $(function() {
        $(document).trigger('scroll')
    })
</script>