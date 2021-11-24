<?php
 session_start();
 $_SESSION['usur'] = ""; 
 $_SESSION['pass'] = "";		
 $Token = rand(0,10000000);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Sistema de Hoteles | DECAMERON</title>

        <link href="libreria/css/bootstrap.min.css" rel="stylesheet">
        <link href="libreria/css/semantic.min.css" rel="stylesheet">
        <link href="libreria/css/sidebar-nav.min.css" rel="stylesheet">
        <link href="libreria/css/animate.css" rel="stylesheet">
        <link href="libreria/css/style.css<?php echo "?V=".time();?>" rel="stylesheet">
        <link href="libreria/css/colores/default.css" id="theme" rel="stylesheet">
        <link href="libreria/css/jquery.toast.css" rel="stylesheet">
    </head>
    <body>
        <div class="preloader">
            <div class="css_fya"></div>
        </div>

        <section id="wrapper" class="login-register" style="background: url(aplicaciones/imagenes/bg.jpg) no-repeat center center/cover !important;">
            <div class="login-box sombreado">
                <div class="white-box">
                    <form autocomplete="off" class="ui form" method="post" id="frmSubmit" action = "aplicaciones/vista/">
                        <div class="field" style="text-align: center;">
                            <img src="aplicaciones/imagenes/logodecameron.jpg">
                            <h3 class="box-title m-b-20">Sistema de Registro y Control de Hoteles</h3>
                        </div>
                        <div class="field">
                            <div class="ui left icon input">
                                <i class="user icon"></i>
                                <input autocomplete="off" type="password" name="usuario" id="username" placeholder="Usuario">
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui left icon input">
                                <i class="lock icon"></i>
                                <input autocomplete="off" type="password" name="password" id="password" placeholder="Contraseña">
                            </div>
                        </div>
                        <div class="field" style="text-align: center;">
                            <input type="hidden" name="token" id="token" value="<?php echo $Token;?>">
                            <button class="ui labeled icon blue button waves-effect waves-light btnSubmit" type="submit">
                                Inicia sesión
                                <i class="unlock alternate icon"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>


        <script src="libreria/js/jquery.min.js"></script>
        <script src="libreria/js/semantic.min.js"></script>
        <script src="libreria/js/bootstrap.min.js"></script>
        <script src="libreria/js/sidebar-nav.min.js"></script>
        <script src="libreria/js/jquery.slimscroll.js"></script>
        <script src="libreria/js/waves.js"></script>
        <script src="libreria/js/custom.min.js"></script>
        <script src="libreria/js/jquery.toast.js"></script>

        <script src="libreria/js/sha1.js<?php echo "?V=".time();?>"></script>
        <script src="libreria/js/aes/aes.min.js"></script>
        <script src="libreria/js/aes/aes-ctr.min.js"></script>
        <script src="libreria/js/base64.min.js"></script>
        <script src="libreria/js/utf8.min.js"></script>


        <script type="text/javascript">	
<?php
if ($_SESSION["token"] == "erroruser")
{
	$_SESSION["token"] = "";
?>
$(function () {
				$.toast({
                    heading:   '¡Vaya! ¡Algo salió mal!',
                    text:      'Error en el usuario y/o la contraseña',
                    position:  'top-right',
                    loaderBg:  '#ff6849',
                    icon:      'error',
                    hideAfter: 3000
                });
                                            });
<?php	
}
?>													
$(function () {
                var $username = $('#username');
                var $password = $('#password');
                var $token    = $('#token');

                $username.focus();
                $('.ui.form').form({
                    on:     'blur',
                    inline: true,
                    fields: {
                        usuario:  {
                            identifier: 'usuario',
                            rules:      [{
                                type:   'empty',
                                prompt: 'Por favor, introduzca nombre de usuario'
                            }]
                        },
                        password: {
                            identifier: 'password',
                            rules:      [{
                                type:   'empty',
                                prompt: 'Por favor, introduzca su contraseña'
                            }, {
                                type:   'length[6]',
                                prompt: 'Tu contraseña debe tener al menos 6 caracteres'
                            }]
                        }
                    }
                });
                $('#frmSubmit').submit(function () {
                    if ($('.ui.form').form('is valid')) {
                        $('.btnSubmit').addClass('loading disabled');
						$username.val(SHA1($username.val()));
                        $password.val(SHA1($password.val()));
                    }
                });
				
            });
        </script>
    </body>
</html>