<h1 class="">Bienvenido a <?php echo $_settings->info('name') ?></h1>
<hr>
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-dark elevation-1"><i class="fas fa-copyright"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Marcas</span>
        <span class="info-box-number">
          <?php
          $inv = $conn->query("SELECT count(id) as total FROM brand_list where delete_flag = 0 ")->fetch_assoc()['total'];
          echo number_format($inv);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-light elevation-1"><i class="fas fa-th-list"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Categorías</span>
        <span class="info-box-number">
          <?php
          $inv = $conn->query("SELECT count(id) as total FROM categories where delete_flag = 0 ")->fetch_assoc()['total'];
          echo number_format($inv);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="shadow info-box mb-3">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users-cog"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Técnicos</span>
        <span class="info-box-number">
          <?php
          $mechanics = $conn->query("SELECT sum(status) as total FROM `mechanics_list` where status = '1' ")->fetch_assoc()['total'];
          echo number_format($mechanics);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->

  <!-- fix for small devices only -->
  <div class="clearfix hidden-md-up"></div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="shadow info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-th-list"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Servicios</span>
        <span class="info-box-number">
          <?php
          $services = $conn->query("SELECT sum(status) as total FROM `service_list` where status = 1 ")->fetch_assoc()['total'];
          echo number_format($services);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="shadow info-box mb-3">
      <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-users"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Clientes Registrados</span>
        <span class="info-box-number">
          <?php
          $services = $conn->query("SELECT sum(id) as total FROM `client_list` where status = 1 and delete_flag = 0 ")->fetch_assoc()['total'];
          echo number_format($services);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="shadow info-box mb-3">
      <span class="info-box-icon bg-gradient-secondary elevation-1"><i class="fas fa-tasks"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Órdenes Pendientes</span>
        <span class="info-box-number">
          <?php
          $services = $conn->query("SELECT sum(status + 1) as total FROM `service_requests` where status = 0 ")->fetch_assoc()['total'];
          echo number_format($services);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="shadow info-box mb-3">
      <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-tasks"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Órdenes Confirmadas</span>
        <span class="info-box-number">
          <?php
          $services = $conn->query("SELECT sum(status) as total FROM `service_requests` where status = 1 ")->fetch_assoc()['total'];
          echo number_format($services);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="shadow info-box mb-3">
      <span class="info-box-icon bg-gradient-success elevation-1"><i class="fas fa-tasks"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">En progreso</span>
        <span class="info-box-number">
          <?php
          $services = $conn->query("SELECT sum(status / 2) as total FROM `service_requests` where status = 2 ")->fetch_assoc()['total'];
          echo number_format($services);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="shadow info-box mb-3">
      <span class="info-box-icon bg-gradient-success elevation-1"><i class="fas fa-tasks"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Ordenes Finalizadas</span>
        <span class="info-box-number">
          <?php
          $services = $conn->query("SELECT sum(status - 2) as total FROM `service_requests` where status = 3 ")->fetch_assoc()['total'];
          echo number_format($services);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="shadow info-box mb-3">
      <span class="info-box-icon bg-gradient-danger elevation-1"><i class="fas fa-tasks"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Órdenes Canceladas</span>
        <span class="info-box-number">
          <?php
          $services = $conn->query("SELECT sum(status - 3) as total FROM `service_requests` where status =4 ")->fetch_assoc()['total'];
          echo number_format($services);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>