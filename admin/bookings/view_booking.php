<?php 
require_once('../../config.php');
?>
<?php 
if(!isset($_GET['id'])){
    $_settings->set_flashdata('error','No Booking ID Provided.');
    redirect('admin/?page=bookings');
}
$booking = $conn->query("SELECT r.*,concat(c.firstname,' ',c.lastname) as client,c.address,c.email,c.contact from `rent_list` r inner join clients c on c.id = r.client_id where r.id = '{$_GET['id']}' ");
if($booking->num_rows > 0){
    foreach($booking->fetch_assoc() as $k => $v){
        $$k = $v;
    }
}else{
    $_settings->set_flashdata('error','Booking ID provided is Unknown');
    redirect('admin/?page=bookings');
}
if(isset($bike_id)){
    $bike = $conn->query("SELECT b.*,c.category, bb.name as brand from `bike_list` b inner join categories c on b.category_id = c.id inner join brand_list bb on b.brand_id = bb.id where b.id = '{$bike_id}' ");
    if($bike->num_rows > 0){
        foreach($bike->fetch_assoc() as $k => $v){
            $bike_meta[$k]=stripslashes($v);
        }
    }
}
?>
<div class="conitaner-fluid px-3 py-2">
    <div class="row">
        <div class="col-md-6">
            <p><b><i class="fas fa-user-edit"></i> Имя клиента: </b> <?php echo $client ?></p>
            <p><b><i class="fas fa-envelope-open-text"></i> Электронная почта клиента: </b> <?php echo $email ?></p>
            <p><b><i class="fas fa-mobile-alt"></i> Контакт с клиентом: </b> <?php echo $contact ?></p>
            <p><b><i class="fas fa-map-marked-alt"></i> Адрес клиента: </b> <?php echo $address ?></p>
            <p><b><i class="fas fa-calendar-day"></i> Дата получения аренды: </b> <?php echo date("M d,Y" ,strtotime($date_start)) ?></p>
            <p><b><i class="fas fa-calendar-check"></i> Дата возврата арендной платы: </b> <?php echo date("M d,Y" ,strtotime($date_end)) ?></p>
        </div>
        <div class="col-md-6">
            <p><b><i class="fas fa-window-restore"></i> Категория мотоцыкла: </b><?php echo $bike_meta['category'] ?></p>
            <p><b><i class="fas fa-ticket-alt"></i> Марка мотоцыкла: </b><?php echo $bike_meta['brand'] ?></p>
            <p><b><i class="fas fa-shekel-sign"></i> Модель мотоцыкла: </b><?php echo $bike_meta['bike_model'] ?></p>
            <p><b><i class="fas fa-calendar-day"></i> Дневная норма мотоцыкла: </b><?php echo number_format($amount/$rent_days,2) ?></p>
            <p><b><i class="fas fa-calendar-check"></i> Дней/с аренды: </b><?php echo $rent_days ?></p>
            <p><b><i class="fas fa-money-check-alt"></i> Сумма к оплате клиентом: </b><?php echo number_format($amount,2) ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-2"><b><i class="fas fa-exclamation-triangle"></i> Статус заказа: </b></div>
        <div class="col-auto">
        <?php 
            switch($status){
                case '0':
                    echo '<span class="badge badge-light text-dark"><i class="fas fa-pen-square"></i> На рассмотрении </span>';
                break;
                case '1':
                    echo '<span class="badge badge-primary"><i class="fas fa-clipboard-check"></i> Подтверждено </span>';
                break;
                case '2':
                    echo '<span class="badge badge-danger"><i class="fas fa-window-close"></i> Отменено </span>';
                break;
                case '3':
                    echo '<span class="badge badge-warning"><i class="fas fa-hand-holding-medical"></i> Подобрали </span>';
                break;
                case '4':
                    echo '<span class="badge badge-success"><i class="fas fa-sync-alt"></i> Возвращено </span>';
                break;
                default:
                    echo '<span class="badge badge-danger"><i class="fas fa-window-close"></i> Oтменен </span>';
                break;
            }
        ?>
        </div>
            
    </div>
</div>
<div class="modal-footer">
    <?php if(!isset($_GET['view'])): ?>
    <button type="button" id="update" class="btn btn-sm btn-success"><i class="fas fa-file-signature"></i> Изменить </button>
    <?php endif; ?>
    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Oтменить </button>
</div>
<style>
    #uni_modal>.modal-dialog>.modal-content>.modal-footer{
        display:none;
    }
    #uni_modal .modal-body{
        padding:0;
    }
</style>
<script>
    $(function(){
        $('#update').click(function(){
            uni_modal("Изменить детали бронирования", "./bookings/manage_booking.php?id=<?php echo $id ?>")
        })
    })
</script>