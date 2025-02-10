<?php require_once('includes/init.php'); ?>
<?php require_once('includes/layout/aside.php'); ?>

<div class="content-wrapper">
    
    <?php
        
        if($_SERVER['PHP_SELF'] == '/book_reader/index.php')
        {
            require_once('includes/layout/content.php');
        }
        
    ?>
    
</div>

<script>
    
    $(document).ready(function(){
        
        $('#sign_in').click(function(e){
            
            e.preventDefault();
            
            $('#popup_back').css('display', 'block');
            $('#popup_front').css('display', 'block');
            
        })

        $('#register').click(function(e){
            
            e.preventDefault();
            
            $('#popup_back').css('display', 'block');
            $('#popup_front2').css('display', 'block');
            
        })
        
        $('.popup_close').click(function(e){
            
            $('#popup_back').css('display', 'none');
            $('#popup_front').css('display', 'none');
            $('#popup_front2').css('display', 'none');
            $('#login_msg').html('');
            $('#register_msg').html('');
            
        })
        
        $('#popup_back').click(function(e){
            
            $('#popup_back').css('display', 'none');
            $('#popup_front').css('display', 'none');
            $('#popup_front2').css('display', 'none');
            $('#login_msg').html('');
            $('#register_msg').html('');
            
        })
        
        $('form.login').submit(function(e){
            
            e.preventDefault();
            var username = $('#username').val();
            var password = $('#password').val();
            
            if(username.length == 0 || password.length == 0)
            {
                $('#login_msg').html('Ulanyjy ady we paroly boş bolmaly däl');
            } else
            {
                $.post(
                    'includes/jquery/login.php',
                    {
                        username: username,
                        password: password
                    },
                    function(data) {
                        
                        if(data == 1)
                        {
                            window.location = 'admin_panel.php';
                        } else
                        {
                            $('#username').val('');
                            $('#password').val('');
                            $('#login_msg').html('Ulanyjy ady ya-da paroly dogry däl');
                        }
                        
                    }
                )
            }
            
        })

        $('form.register').submit(function(e){
            
            e.preventDefault();
            var first_name = $('#first_name').val();
            var last_name = $('#last_name').val();
            var phone = $('#phone').val();
            var username = $('#username2').val();
            var password = $('#password2').val();
            
            if(first_name.length == 0 || last_name.length == 0 || phone.length == 0 
                || username.length == 0 || password.length == 0)
            {
                $('#register_msg').html('Ähli öýjükler doldurylmaly');
            } else
            {
                $.post(
                    'includes/jquery/register.php',
                    {
                        first_name: first_name,
                        last_name: last_name,
                        phone: phone,
                        username: username,
                        password: password
                    },
                    function(data) {
                        
                        $('#register_msg').html('Ulanyjy üstünlik bilen ulgama goşuldy').css('color', 'green');

                        setTimeout(() => {
                            $('#popup_back').css('display', 'none');
                            $('#popup_front').css('display', 'none');
                            $('#popup_front2').css('display', 'none');
                            $('#login_msg').html('');
                            $('#register_msg').html('');
                        }, 1000);
                        
                    }
                )
            }
            
        })
        
    })
    
</script>

<?php require_once('includes/layout/footer.php'); ?>