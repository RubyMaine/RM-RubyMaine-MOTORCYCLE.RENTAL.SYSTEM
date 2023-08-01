<style>
    table td,table th{
        padding: 3px !important;
    }
</style>
<?php 
$date_start = isset($_GET['date_start']) ? $_GET['date_start'] :  date("Y-m-d",strtotime(date("Y-m-d")." -7 days")) ;
$date_end = isset($_GET['date_end']) ? $_GET['date_end'] :  date("Y-m-d") ;
?>
<div class="card card-primary card-outline">
    <div class="card-header">
        <h5 class="card-title"><i class="fas fa-file-excel"></i> Отчет о продажах </h5>
    </div>
    <div class="card-body">
        <form id="filter-form">
            <div class="row align-items-end">
                <div class="form-group col-md-3">
                    <label for="date_start"><i class="fas fa-calendar-plus"></i> Дата начала: </label>
                    <input type="date" class="form-control form-control-sm" name="date_start" value="<?php echo date("Y-m-d",strtotime($date_start)) ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="date_start"><i class="fas fa-calendar-check"></i> Дата окончания: </label>
                    <input type="date" class="form-control form-control-sm" name="date_end" value="<?php echo date("Y-m-d",strtotime($date_end)) ?>">
                </div>
                <div class="form-group col-md-1">
                    <button class="btn btn-flat btn-block btn-primary btn-sm"><i class="fa fa-filter"></i> Фильтровать </button>
                </div>
                <div class="form-group col-md-1">
                    <button class="btn btn-flat btn-block btn-success btn-sm" type="button" id="printBTN"><i class="fa fa-print"></i> Распечатать </button>
                </div>
            </div>
        </form>
        <hr>
        <div id="printable">
            <div>
                <h4 class="text-center m-0"><i class="fas fa-motorcycle"></i> <?php echo $_settings->info('name') ?></h4>
                <h3 class="text-center m-0"><b><i class="fas fa-chart-line"></i> Отчет о бронировании </b></h3>
                <p class="text-center m-0"><i class="far fa-calendar-alt"></i> Дата между <?php echo $date_start ?> и <?php echo $date_end ?></p>
                <hr>
            </div>
            <table class="table table-bordered" style="text-align: center;">
                <colgroup>
					<col width="5%">
					<col width="20%">
					<col width="25%">
					<col width="25%">
					<col width="25%">
				</colgroup>
                <thead>
                    <tr class="bg-navy text-white">
                        <th style="text-align: center;"> # ID: </th>
						<th style="text-align: center;"> Дата бронирования: </th>
						<th style="text-align: center;"> Расписание аренды: </th>
						<th style="text-align: center;"> Клиент: </th>
						<th style="text-align: center;"> Информация о мотоцыкла: </th>
					</tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                        $bike = $conn->query("SELECT b.*,c.category, bb.name as brand from `bike_list` b inner join categories c on b.category_id = c.id inner join brand_list bb on b.brand_id = bb.id ");
                        while($row= $bike->fetch_assoc()){
                            foreach($row as $k=>$v){
                                if(!is_numeric($k)){
                                    $bike_arr[$row['id']][$k] = $v;
                                }
                            }
                        }

                        $where = " where date(r.date_created) between '{$date_start}' and '{$date_end}'";
                        $qry = $conn->query("SELECT r.*,concat(c.firstname,' ',c.lastname) as client,c.address,c.email,c.contact from `rent_list` r inner join clients c on c.id = r.client_id {$where} order by unix_timestamp(r.date_created) desc ");
                        while($row = $qry->fetch_assoc()):
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i++ ?></td>
                        <td><?php echo $row['date_created'] ?></td>
                        <td>
                            <small><span class="text-muted"><i class="fas fa-calendar-plus"></i> Получение: </span><?php echo date("Y-m-d",strtotime($row['date_start'])) ?></small><br>
                            <small><span class="text-muted"><i class="fas fa-calendar-check"></i> Возврат: </span><?php echo date("Y-m-d",strtotime($row['date_end'])) ?></small><br>
                            <small><span class="text-muted"><i class="fas fa-money-check-alt"></i> Сумма оплата: </span><?php echo number_format($row['amount']) ?></small><br>
                            <small><span class="text-muted"><i class="fas fa-exclamation-triangle"></i> Состояние: </span>
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
                            </small>
                        </td>
                        <td>
                            <small><span class="text-muted"><i class="fas fa-user-check"></i> Имя: </span><?php echo $row['client'] ?></small><br>
                            <small><span class="text-muted"><i class="fas fa-envelope-open-text"></i> Электронная почта: </span><?php echo $row['email'] ?></small><br>
                            <small><span class="text-muted"><i class="fas fa-mobile-alt"></i> Контакт: </span><?php echo $row['contact'] ?></small>
                        </td>
                        <td>
                            <small><span class="text-muted"><i class="fab fa-bandcamp"></i> Категория: </span><?php echo isset($bike_arr[$row['bike_id']]) ? $bike_arr[$row['bike_id']]['category'] : 'N/A' ?></small><br>
                            <small><span class="text-muted"><i class="fas fa-shekel-sign"></i> Бренд: </span><?php echo isset($bike_arr[$row['bike_id']]) ? $bike_arr[$row['bike_id']]['brand'] : 'N/A' ?></small><br>
                            <small><span class="text-muted"><i class="fas fa-motorcycle"></i> Мотоцыкла: </span><?php echo isset($bike_arr[$row['bike_id']]) ? $bike_arr[$row['bike_id']]['bike_model'] : 'N/A' ?></small>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php if($qry->num_rows <= 0): ?>
                    <tr>
                        <th class="text-center" colspan="5"><i class="fas fa-times-circle"></i> Нет данных...</th>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<noscript>
    <style>
        .m-0{
            margin:0;
        }
        .text-center{
            text-align:center;
        }
        .text-right{
            text-align:right;
        }
        .table{
            border-collapse:collapse;
            width: 100%
        }
        .table tr,.table td,.table th{
            border:1px solid gray;
        }
        html, body, .wrapper {
            min-height: inherit !important;
        }
    </style>
</noscript>
<script>
    $(function(){
        $('#filter-form').submit(function(e){
            e.preventDefault()
            location.href = "./?page=report&date_start="+$('[name="date_start"]').val()+"&date_end="+$('[name="date_end"]').val()
        })

        $('#printBTN').click(function(){
            var h = $('head').clone();
            var rep = $('#printable').clone();
            var ns = $('noscript').clone().html();
            rep.find('tr').removeClass('bg-navy text-white')
            start_loader()
            rep.prepend(ns)
            rep.prepend(h)
            var nw = window.document.open('','_blank','width=900,height=600')
                nw.document.write(rep.html())
                nw.document.close()
                setTimeout(function(){
                nw.print()
                    setTimeout(function(){
                        nw.close()
                        end_loader()
                    },200)
                },500)
        })
    })
</script>