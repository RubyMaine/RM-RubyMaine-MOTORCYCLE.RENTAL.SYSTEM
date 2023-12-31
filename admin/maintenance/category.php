<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title"><i class="fas fa-stream"></i> Список категорий </h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-primary bg-navy border-0"><span class="fas fa-plus"></span> Создавать новое </a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hovered table-striped">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="35%">
					<col width="10%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr class="bg-navy text-white" style="text-align: center;">
						<th> # ID: </th>
						<th> Дата создания: </th>
						<th> Категория: </th>
						<th> Описание: </th>
						<th> Cостояние: </th>
						<th> Действие: </th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT * from `categories` order by `category` asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td class="text-center"><?php echo $row['category'] ?></td>
							<td class="text-center"><p class="truncate-1 m-0"><?php echo $row['description'] ?></p></td>
							<td class="text-center">
                                <?php if($row['status'] == 1): ?>
                                    <span class="badge badge-success rounded-pill"><i class="fas fa-check-square"></i> Активный </span>
                                <?php else: ?>
                                    <span class="badge badge-danger rounded-pill"><i class="fas fa-times-circle"></i> Неактивный </span>
                                <?php endif; ?>
                            </td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"><i class="fas fa-exclamation-triangle"></i> Действие <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Редактировать </a>
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
		$('#create_new').click(function(){
			uni_modal("<i class='fa fa-plus'></i> Добавить новую категорию ", 'maintenance/manage_category.php')
		})
		$('.edit_data').click(function(){
			uni_modal("<i class='fa fa-edit'></i> Изменить сведения о категориях ", 'maintenance/manage_category.php?id='+$(this).attr('data-id'))
		})
		$('.delete_data').click(function(){
			_conf("Вы уверены, что хотите удалить эту категорию навсегда?","delete_category",[$(this).attr('data-id')])
		})
		$('.table td,.table th').addClass('px-2 py-1')
		$('.table').dataTable({
			columnDefs: [
				{ targets: [4, 5], orderable: false}
			],
			initComplete:function(settings, json){
				$('.table td,.table th').addClass('px-2 py-1')
			}
		});
	})
	function delete_category($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_category",
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