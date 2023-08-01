    
<style>
    .badge-light{
        color:black
    }
</style>
<section class="py-2">
    <div class="container">
        <div class="card rounded-0">
            <div class="card-body">
                <div class="w-100 justify-content-between d-flex">
                    <h4><b><i class="fas fa-clipboard-list"></i> Все мои заказы </b></h4>
                    <a href="./?p=edit_account" class="btn btn-primary rounded-2"><div class="fa fa-user-cog"></div> Управление учетной записью </a>
                </div>
                    <hr class="border-warning">
                    <table class="table table-stripped text-dark">
                        <colgroup>
                            <col width="5%">
                            <col width="15%">
                            <col width="25%">
                            <col width="20%">
                            <col width="10%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                            <tr class="bg-navy text-white">
                                <th> # ID: </th>
                                <th> Дата бронирования: </th>
                                <th> График аренды: </th>
                                <th> Клиенты: </th>
                                <th> Состояние: </th>
                                <th> Действие: </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i = 1;
                                $qry = $conn->query("SELECT r.*,concat(c.firstname,' ',c.lastname) as client from `rent_list` r inner join clients c on c.id = r.client_id where client_id = '{$_settings->userdata('id')}' order by unix_timestamp(r.date_created) desc ");
                                while($row = $qry->fetch_assoc()):
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
                                <td>
                                    <small><span class="text-muted"> Подобрать: </span><?php echo date("Y-m-d",strtotime($row['date_start'])) ?></small><br>
                                    <small><span class="text-muted"> Возвращаться: </span><?php echo date("Y-m-d",strtotime($row['date_end'])) ?></small>
                                </td>
                                <td><?php echo $row['client'] ?></td>
                                <td class="text-center">
                                    <?php if($row['status'] == 0): ?>
                                        <span class="badge badge-info"><i class="fas fa-pen-square"></i> В ожидании </span>
                                    <?php elseif($row['status'] == 1): ?>
                                        <span class="badge badge-primary"><i class="fas fa-check-square"></i> Подтвержденный </span>
                                    <?php elseif($row['status'] == 2): ?>
                                        <span class="badge badge-danger"><i class="fas fa-window-close"></i> Отменено </span>
                                    <?php elseif($row['status'] == 3): ?>
                                        <span class="badge badge-warning"><i class="fas fa-clipboard-check"></i> Подобрали </span>
                                    <?php elseif($row['status'] == 4): ?>
                                        <span class="badge badge-success"><i class="fas fa-undo"></i> Возвращено </span>
                                    <?php else: ?>
                                        <span class="badge badge-danger"><i class="far fa-window-close"></i> Отменен </span>
                                    <?php endif; ?>
                                </td>
                                <td align="center">
                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"><i class="fas fa-exclamation-triangle"></i> Действие <span class="sr-only">Toggle Dropdown</span></button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fas fa-eye"></span> Посмотреть подробности </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</section>
<script>
    $(function(){
        $('.view_data').click(function(){
            uni_modal("Order Details","./admin/bookings/view_booking.php?view=user&id="+$(this).attr('data-id'),'large')
        })
        $('table').dataTable();

    })
</script>