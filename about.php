 <!-- Header-->
 <header class="bg-dark py-5" id="main-header">
     <div class="container h-100 d-flex align-items-end justify-content-center w-100">
         <div class="text-center text-white w-100">
             <h1 class="display-4 fw-bolder mx-5">Nosotros</h1>
         </div>
     </div>
 </header>
 <section class="py-5">
     <div class="container">
         <div class="card rounded-0">
             <div class="card-body">
                 <?php include "about.html" ?>
             </div>
         </div>
     </div>
 </section>

 <script>
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