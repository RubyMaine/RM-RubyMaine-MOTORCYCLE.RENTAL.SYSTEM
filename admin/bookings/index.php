<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php if($_settings->chk_flashdata('error')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('error') ?>",'error')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title"><i class="fas fa-clipboard-list"></i> Список бронирований </h3>
		<!-- <div class="card-tools">
			<a href="?page=order/manage_order" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div> -->
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-striped" style="text-align: center;">
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
						<th style="text-align: center;"> # ID: </th>
						<th style="text-align: center;"> Дата бронирования: </th>
						<th style="text-align: center;"> Расписание аренды: </th>
						<th style="text-align: center;"> Заказчик: </th>
						<th style="text-align: center;"> Состояние: </th>
						<th style="text-align: center;"> Действие: </th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT r.*,concat(c.firstname,' ',c.lastname) as client from `rent_list` r inner join clients c on c.id = r.client_id order by unix_timestamp(r.date_created) desc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td>
								<small><span class="text-muted"> Торговая марка:</span><?php echo date("Y-m-d",strtotime($row['date_start'])) ?></small><br>
								<small><span class="text-muted"> Модель: </span><?php echo date("Y-m-d",strtotime($row['date_end'])) ?></small>
							</td>
							<td><?php echo $row['client'] ?></td>
							<td class="text-center">
                                <?php if($row['status'] == 0): ?>
                                    <span class="badge badge-light"><i class="fas fa-pen-square"></i> На рассмотрении </span>
                                <?php elseif($row['status'] == 1): ?>
                                    <span class="badge badge-primary"><i class="fas fa-clipboard-check"></i> Подтверждено </span>
								<?php elseif($row['status'] == 2): ?>
                                    <span class="badge badge-danger"><i class="fas fa-window-close"></i> Отменено </span>
								<?php elseif($row['status'] == 3): ?>
                                    <span class="badge badge-warning"><i class="fas fa-hand-holding-medical"></i> Подобрали </span>
								<?php elseif($row['status'] == 4): ?>
                                    <span class="badge badge-success"><i class="fas fa-sync-alt"></i> Возвращено </span>
                                <?php else: ?>
                                    <span class="badge badge-danger"><i class="fas fa-window-close"></i> Oтменен </span>
                                <?php endif; ?>
                            </td>
							<td align="center">
								 <button type="button" class="btn btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"><i class="fas fa-exclamation-triangle"></i> Действие <span class="sr-only">Toggle Dropdown</span></button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Просматривать </a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Удалить </a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Вы уверены, что хотите удалить это бронирование навсегда?","delete_booking",[$(this).attr('data-id')])
		})
		$('.view_data').click(function(){
			uni_modal('Информация о бронировании','bookings/view_booking.php?id='+$(this).attr('data-id'),'mid-large')
		})
		$('.table').dataTable();
	})
	function delete_booking($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_booking",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>