<div class="content py-5 mt-3">
    <div class="container">
        <h3><b>Mis Solicitudes de Servicio</b></h3>
        <hr>
        <div class="card card-outline card-dark shadow rounded-0">
            <div class="card-body">
                <div class="container-fluid">
                    <table class="table table-stripped table-bordered">
                        <colgroup>
                            <col width="5%">
                            <col width="20%">
                            <col width="25%">
                            <col width="20%">
                            <col width="15%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                            <tr class="bg-gradient-dark text-light">
                                <th class="text-center">#</th>
                                <th class="text-center">Fecha de Solicitud</th>
                                <th class="text-center">Técnico</th>
                                <th class="text-center">Servicio</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $mechanic = $conn->query("SELECT * FROM mechanics_list where id in (SELECT mechanic_id FROM `service_requests` where client_id = '{$_settings->userdata('id')}')");
                            $mechanic_arr = array_column($mechanic->fetch_all(MYSQLI_ASSOC), 'name', 'id');
                            $orders = $conn->query("SELECT * FROM `service_requests` where client_id = '{$_settings->userdata('id')}' order by unix_timestamp(date_created) desc ");
                            while ($row = $orders->fetch_assoc()) :
                            ?>
                                <tr>
                                    <td class="text-center"><?= $i++ ?></td>
                                    <td><?= date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                                    <td>
                                        <p class="truncate-1 m-0"><?= isset($mechanic_arr[$row['mechanic_id']]) ? $mechanic_arr[$row['mechanic_id']] : "N/A" ?></p>
                                    </td>
                                    <td class=""><?= $row['service_type'] ?></td>
                                    <td class="text-center">
                                        <?php if ($row['status'] == 1) : ?>
                                            <span class="badge badge-primary rounded-pill px-3">Confirmado</span>
                                        <?php elseif ($row['status'] == 2) : ?>
                                            <span class="badge badge-warning rounded-pill px-3">En Progreso</span>
                                        <?php elseif ($row['status'] == 3) : ?>
                                            <span class="badge badge-success rounded-pill px-3">Done</span>
                                        <?php elseif ($row['status'] == 4) : ?>
                                            <span class="badge badge-danger rounded-pill px-3">Cancelado</span>
                                        <?php else : ?>
                                            <span class="badge badge-secondary rounded-pill px-3">Pendiente</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-flat btn-sm btn-default border view_data" type="button" data-id="<?= $row['id'] ?>"><i class="fa fa-eye"></i> Ver</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('.view_data').click(function() {
            uni_modal("Service Request Details", "view_request.php?id=" + $(this).attr('data-id'), "mid-large")
        })

        $('.table th, .table td').addClass("align-middle px-2 py-1")
        $('.table').dataTable();
        $('.table').dataTable();
    })
</script>