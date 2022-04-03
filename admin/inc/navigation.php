</style>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-no-expand">
  <!-- Brand Logo -->
  <a href="<?php echo base_url ?>admin" class="brand-link bg-primary text-sm">
    <img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="Store Logo" class="brand-image img-circle elevation-3" style="opacity: .8;width: 1.6rem;height: 1.6rem;max-height: unset">
    <span class="brand-text font-weight-light"><?php echo $_settings->info('short_name') ?></span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
    <div class="os-resize-observer-host observed">
      <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
    </div>
    <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
      <div class="os-resize-observer"></div>
    </div>
    <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
    <div class="os-padding">
      <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
        <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
          <!-- Sidebar user panel (optional) -->
          <div class="clearfix"></div>
          <!-- Sidebar Menu -->
          <nav class="mt-4">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item dropdown">
                <a href="./" class="nav-link nav-home">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=products" class="nav-link nav-products">
                  <i class="nav-icon fas fa-table"></i>
                  <p>
                    Productos
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=inventory" class="nav-link nav-inventory">
                  <i class="nav-icon fas fa-boxes"></i>
                  <p>
                    Inventario
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=orders" class="nav-link nav-orders">
                  <i class="nav-icon fas fa-tasks"></i>
                  <p>
                    Órdenes
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=service_requests" class="nav-link nav-service_requests">
                  <i class="nav-icon fas fa-file-invoice"></i>
                  <p>
                    Solicitudes Servicios
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=mechanics" class="nav-link nav-mechanics">
                  <i class="nav-icon fas fa-user-friends"></i>
                  <p>
                    Técnicos
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=clients" class="nav-link nav-clients">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    Clientes Registrados
                  </p>
                </a>
              </li>
              <li class="nav-header">Reportes</li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=report/service_requests" class="nav-link nav-report_service_requests">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    Informe de solicitudes de servicio
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=report/orders" class="nav-link nav-report_orders">
                  <i class="nav-icon fas fa-circle"></i>
                  <p>
                    Reporte de Órdenes
                  </p>
                </a>
              </li>
              <?php if ($_settings->userdata('type') == 1) : ?>
                <li class="nav-header">Mantenimiento</li>
                <li class="nav-item dropdown">
                  <a href="<?php echo base_url ?>admin/?page=maintenance/brands" class="nav-link nav-maintenance_brands">
                    <i class="nav-icon fas fa-copyright"></i>
                    <p>
                      Marcas
                    </p>
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a href="<?php echo base_url ?>admin/?page=maintenance/category" class="nav-link nav-maintenance_category">
                    <i class="nav-icon fas fa-th-list"></i>
                    <p>
                      Categorías
                    </p>
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a href="<?php echo base_url ?>admin/?page=maintenance/services" class="nav-link nav-maintenance_services">
                    <i class="nav-icon fas fa-th-list"></i>
                    <p>
                      Servicios
                    </p>
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a href="<?php echo base_url ?>admin/?page=user/list" class="nav-link nav-user_list">
                    <i class="nav-icon fas fa-users-cog"></i>
                    <p>
                      Usuarios
                    </p>
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a href="<?php echo base_url ?>admin/?page=system_info" class="nav-link nav-system_info">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>
                      Configuración
                    </p>
                  </a>
                </li>
              <?php endif; ?>
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
      </div>
    </div>
    <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
      <div class="os-scrollbar-track">
        <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
      </div>
    </div>
    <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
      <div class="os-scrollbar-track">
        <div class="os-scrollbar-handle" style="height: 55.017%; transform: translate(0px, 0px);"></div>
      </div>
    </div>
    <div class="os-scrollbar-corner"></div>
  </div>
  <!-- /.sidebar -->
</aside>
<script>
  $(document).ready(function() {
    var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
    var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
    page = page.replace('/', "_");
    if (s != '')
      page = page + '_' + s;

    if ($('.nav-link.nav-' + page).length > 0) {
      $('.nav-link.nav-' + page).addClass('active')
      if ($('.nav-link.nav-' + page).hasClass('tree-item') == true) {
        $('.nav-link.nav-' + page).closest('.nav-treeview').siblings('a').addClass('active')
        $('.nav-link.nav-' + page).closest('.nav-treeview').parent().addClass('menu-open')
      }
      if ($('.nav-link.nav-' + page).hasClass('nav-is-tree') == true) {
        $('.nav-link.nav-' + page).parent().addClass('menu-open')
      }

    }

  })
</script>