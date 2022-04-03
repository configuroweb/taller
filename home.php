 <!-- Header-->
 <header class="bg-dark py-5" id="main-header">
     <div class="container h-100 d-flex align-items-end justify-content-center w-100">
         <div class="text-center text-white w-100">
             <h1 class="display-4 fw-bolder mx-5"><?php echo $_settings->info('name') ?></h1>
             <div class="col-auto mt-2">
                 <a class="btn btn-warning btn-lg rounded-0" href="./?p=products">Comprar</a>
             </div>
         </div>
     </div>
 </header>
 <!-- Section-->
 <section class="py-5">
     <div class="container px-4 px-lg-5 mt-5">
         <div class="row row-cols-sm-1 row-cols-md-2 row-cols-xl-4">
             <?php
                $products = $conn->query("SELECT p.*,b.name as brand, c.category FROM `product_list` p inner join brand_list b on p.brand_id = b.id inner join `categories` c on p.category_id = c.id where p.delete_flag = 0 and p.status = 1 order by RAND() limit 4");
                while ($row = $products->fetch_assoc()) :
                ?>
                 <a class="col px-1 py-2 text-decoration-none text-dark product-item" href="./?p=products/view_product&id=<?= $row['id'] ?>">
                     <div class="card rounded-0 shadow">
                         <div class="product-img-holder overflow-hidden position-relative">
                             <img src="<?= validate_image($row['image_path']) ?>" alt="Product Image" class="img-top" />
                             <span class="position-absolute price-tag rounded-pill bg-gradient-warning text-light px-3">
                                 <i class="fa fa-tags"></i> <b><?= number_format($row['price'], 2) ?></b>
                             </span>
                         </div>
                         <div class="card-body border-top">
                             <h4 class="card-title my-0"><b><?= $row['name'] ?></b></h4><br>
                             <small class="text-muted"><?= $row['brand'] ?></small><br>
                             <small class="text-muted"><?= $row['category'] ?></small>
                             <p class="m-0 truncate-5"><?= strip_tags(html_entity_decode($row['description'])) ?></p>
                         </div>
                     </div>
                 </a>
             <?php endwhile; ?>
         </div>
     </div>
 </section>
 <script>
     $(function() {
         $('#search').on('input', function() {
             var _search = $(this).val().toLowerCase().trim()
             $('#service_list .item').each(function() {
                 var _text = $(this).text().toLowerCase().trim()
                 _text = _text.replace(/\s+/g, ' ')
                 console.log(_text)
                 if ((_text).includes(_search) == true) {
                     $(this).toggle(true)
                 } else {
                     $(this).toggle(false)
                 }
             })
             if ($('#service_list .item:visible').length > 0) {
                 $('#noResult').hide('slow')
             } else {
                 $('#noResult').show('slow')
             }
         })
         $('#service_list .item').hover(function() {
             $(this).find('.callout').addClass('shadow')
         })
         $('#service_list .view_service').click(function() {
             uni_modal("Service Details", "view_service.php?id=" + $(this).attr('data-id'), 'mid-large')
         })
         $('#send_request').click(function() {
             uni_modal("Fill the Service Request Form", "send_request.php", 'large')
         })

     })
     $(document).scroll(function() {
         $('#topNavBar').removeClass('bg-transparent navbar-dark bg-primary')
         if ($(window).scrollTop() === 0) {
             $('#topNavBar').addClass('navbar-dark bg-transparent')
         } else {
             $('#topNavBar').addClass('navbar-dark bg-primary')
         }
     });
     $(function() {
         $(document).trigger('scroll')
     })
 </script>