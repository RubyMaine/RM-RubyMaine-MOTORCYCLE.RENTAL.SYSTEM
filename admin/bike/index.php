<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title"><i class="fas fa-motorcycle"></i> Список мотоцыклов </h3>
		<div class="card-tools">
			<a href="?page=bike/manage_bike" class="btn btn-primary"><span class="fas fa-plus"></span> Добавить новое мотоцыкла </a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-striped" style="text-align: center;">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="25%">
					<col width="30%">
					<col width="10%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr class="bg-navy text-white">
						<th style="text-align: center;"> # ID: </th>
						<th style="text-align: center;"> Дата создания: </th>
						<th style="text-align: center;"> Категория: </th>
						<th style="text-align: center;"> Информация о мотоцыкла:</th>
						<th style="text-align: center;"> Количество: </th>
						<th style="text-align: center;"> Состояние: </th>
						<th style="text-align: center;"> Действие: </th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT b.*,c.category, bb.name as brand from `bike_list` b inner join categories c on b.category_id = c.id inner join brand_list bb on b.brand_id = bb.id order by b.bike_model asc ");
						while($row = $qry->fetch_assoc()):
							foreach($row as $k=> $v){
								$row[$k] = trim(stripslashes($v));
							}
                            $row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td><?php echo $row['category'] ?></td>
							<td class="lh-1" >
								<small><span class="text-muted">Торговая марка:</span> <?php echo $row['brand'] ?></small><br>
								<small><span class="text-muted">Модель:</span> <?php echo $row['bike_model'] ?></small>
							</td>
							<td class="text-end"><?php echo number_format($row['quantity']) ?></td>
							<td class="text-center">
                                <?php if($row['status'] == 1): ?>
                                    <span class="badge badge-success"><i class="fas fa-check-square"></i> Активный </span>
                                <?php else: ?>
                                    <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Неактивный </span>
                                <?php endif; ?>
                            </td>
							<td align="center">
								 <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown"><i class="fas fa-exclamation-triangle"></i> Действие <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
								  	<a class="dropdown-item" href="<?php echo base_url ?>?p=view_bike&id=<?php echo md5($row['id']) ?>" target="_blank"><span class="fa fa-eye text-dark"></span> Просматривать </a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item" href="?page=bike/manage_bike&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Редактировать </a>
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
			_conf("Are you sure to delete this bike permanently?","delete_bike",[$(this).attr('data-id')])
		})
		$('.table td,.table th').addClass('px-2 py-1')
		$('.table').dataTable({
			columnDefs: [
				{ targets: [5, 6], orderable: false}
			],
			initComplete:function(settings, json){
				$('.table td,.table th').addClass('px-2 py-1')
			}
		});
	})
	function delete_bike($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_bike",
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