<section class="py-5">
    <div class="container">
        <div class="card rounded-0">
            <div class="card-body">
                <div class="w-100 justify-content-between d-flex">
                    <h4><b><i class="fas fa-edit"></i> Обновить данные учетной записи </b></h4>
                    <a href="./?p=my_account" class="btn btn-info rounded-2"><div class="fas fa-backspace"></div> Назад к списку заказов </a>
                </div>
                    <hr class="border-warning">
                    <div class="col-md-6">
                        <form action="" id="update_account">
                        <input type="hidden" name="id" value="<?php echo $_settings->userdata('id') ?>">
                            <div class="form-group">
                                <label for="firstname" class="control-label"><i class="fas fa-user-edit"></i> Имя: </label>
                                <input type="text" name="firstname" class="form-control form" placeholder="(Введите ваш имя) ..." value="<?php echo $_settings->userdata('firstname') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="lastname" class="control-label"><i class="fas fa-user-edit"></i> Фамилия: </label>
                                <input type="text" name="lastname" class="form-control form" placeholder="(Введите ваш фамилию) ..." value="<?php echo $_settings->userdata('lastname') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label"><i class="fas fa-mobile-alt"></i> Контактый номер:</label>
                                <input type="text" class="form-control form-control-sm form" name="contact" placeholder="(Введите ваш контакные номер) ..." value="<?php echo $_settings->userdata('contact') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label"><i class="fas fa-restroom"></i> Ваш пол: </label>
                                <select name="gender" id="" class="custom-select select" required>
                                    <option <?php echo $_settings->userdata('gender') == "Male" ? "selected" : '' ?>> Мужской </option>
                                    <option <?php echo $_settings->userdata('gender') == "Female" ? "selected" : '' ?>> Женский </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label"><i class="fas fa-map-marked-alt"></i> Адрес: </label>
                                <textarea class="form-control form" rows='3' name="address" placeholder="(Введите ваш адрес) ..."><?php echo $_settings->userdata('address') ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="email" class="control-label"><i class="fas fa-mail-bulk"></i> Электронная почта: </label>
                                <input type="text" name="email" class="form-control form" placeholder="(Введите электронная почту) ..." value="<?php echo $_settings->userdata('email') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label"><i class="fas fa-unlock-alt"></i> Новый пароль: </label>
                                <input type="password" name="password" class="form-control form" value="" placeholder="(Введите значение, чтобы изменить пароль) ...">
                            </div>
                            <div class="form-group">
                                <label for="cpassword" class="control-label"><i class="fas fa-unlock-alt"></i> Повторение пароль: </label>
                                <input type="password" name="cpassword" class="form-control form" value="" placeholder="(Введите значение, паторное изменить пароль) ...">
                            </div>
                            <div class="form-group d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm rounded-2"><i class="fas fa-clipboard-check"></i> Сохранить </button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</section>
<script>
$(function(){
        $('#update_account [name="password"],#update_account [name="cpassword"]').on('input',function(){
            if($('#update_account [name="password"]').val() != '' || $('#update_account [name="cpassword"]').val() != '')
            $('#update_account [name="password"],#update_account [name="cpassword"]').attr('required',true);
            else
            $('#update_account [name="password"],#update_account [name="cpassword"]').attr('required',false);
        })
        $('#update_account').submit(function(e){
            e.preventDefault();
            start_loader()
            if($('.err-msg').length > 0)
                $('.err-msg').remove();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=update_account",
                method:"POST",
                data:$(this).serialize(),
                dataType:"json",
                error:err=>{
                    console.log(err)
                    alert_toast("an error occured",'error')
                    end_loader()
                },
                success:function(resp){
                    if(typeof resp == 'object' && resp.status == 'success'){
                        alert_toast("Account succesfully updated",'success');
                        $('#update_account [name="password"],#update_account [name="cpassword"]').attr('required',false);
                        $('#update_account [name="password"],#update_account [name="cpassword"]').val('');
                    }else if(resp.status == 'failed' && !!resp.msg){
                        var _err_el = $('<div>')
                            _err_el.addClass("alert alert-danger err-msg").text(resp.msg)
                        $('#update_account').prepend(_err_el)
                        $('body, html').animate({scrollTop:0},'fast')
                        end_loader()
                        
                    }else{
                        console.log(resp)
                        alert_toast("an error occured",'error')
                    }
                    end_loader()
                }
            })
        })
    })
</script>