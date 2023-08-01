<style>
    #uni_modal .modal-content>.modal-footer,#uni_modal .modal-content>.modal-header{
        display:none;
    }
</style>
<div class="container-fluid">
    <form action="" id="registration">
        <div class="row">
        
        <h3 class="text-center"><i class="fas fa-user-plus"></i> Создать новый аккаунт
            <span class="float-right">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </span>
        </h3>
            <hr>
        </div>
        <div class="row  align-items-center h-100">
            
            <div class="col-lg-5 border-right">
                
                <div class="form-group">
                    <label for="" class="control-label"><i class="fas fa-user-edit"></i> Имя: </label>
                    <input type="text" class="form-control form-control-sm form" name="firstname" placeholder=" Имя ... " required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label"><i class="fas fa-user-edit"></i> Фамилия: </label>
                    <input type="text" class="form-control form-control-sm form" name="lastname" placeholder=" Фамилия ... " required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label"><i class="fas fa-mobile-alt"></i> Контактный телефон номер:</label>
                    <input type="text" class="form-control form-control-sm form" name="contact" placeholder=" Контактный телефон номер ... " required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label"><i class="fas fa-restroom"></i> Ваш пол: </label>
                    <select name="gender" id="" class="custom-select select" required>
                        <option> Мужской </option>
                        <option> Женский </option>
                    </select>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="form-group">
                    <label for="" class="control-label"><i class="fas fa-map-marked-alt"></i> Адрес: </label>
                    <textarea class="form-control form" rows='3' placeholder=" Адрес ... " name="address"></textarea>
                </div>
                <div class="form-group">
                    <label for="" class="control-label"><i class="fas fa-mail-bulk"></i> Электронная почта: </label>
                    <input type="text" class="form-control form-control-sm form" placeholder=" Электронная почта ... " name="email" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label"><i class="fas fa-unlock-alt"></i> Пароль: </label>
                    <input type="password" class="form-control form-control-sm form" placeholder=" Пароль ... " name="password" required>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <a class="btn btn-info rounded-2" href="javascript:void()" id="login-show"><i class="fas fa-id-badge"></i> У вас уже есть аккаунт? </a>
                    <button class="btn btn-primary rounded-2"><i class="fas fa-file-signature"></i> Зарегистрироваться </button>
                </div>
            </div>
        </div>
    </form>

</div>
<script>
    $(function(){
        $('#login-show').click(function(){
            uni_modal("","login.php")
        })
        $('#registration').submit(function(e){
            e.preventDefault();
            start_loader()
            if($('.err-msg').length > 0)
                $('.err-msg').remove();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=register",
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
                        alert_toast("Account succesfully registered",'success')
                        setTimeout(function(){
                            location.reload()
                        },2000)
                    }else if(resp.status == 'failed' && !!resp.msg){
                        var _err_el = $('<div>')
                            _err_el.addClass("alert alert-danger err-msg").text(resp.msg)
                        $('[name="password"]').after(_err_el)
                        end_loader()
                        
                    }else{
                        console.log(resp)
                        alert_toast("an error occured",'error')
                        end_loader()
                    }
                }
            })
        })
       
    })
</script>