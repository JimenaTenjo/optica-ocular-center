<?php
require("../../partials/routes.php");
if(!empty($_GET['respuesta']) && isset($_GET['respuesta'])){
    $respuesta = $_GET['respuesta'];
}else{
    $respuesta = "";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= getenv('TITLE_SITE') ?> | Login</title>
    <?php require("../../partials/head_imports.php"); ?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>OcularCenter</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Iniciar sesión</p>

            <form action="../../../App/Controlador/PersonaControlador.php?action=login" method="post">
                <div class="input-group mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Ingresar email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input class="form-control" type="password" name="password" placeholder="ingresar contraseña">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block" name="iniciar"> <i class="fas fa-sign-in-alt"></i> Ingresar</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->
<?php require ('../../partials/scripts.php');?>
<script>
    $(document).ready(function() {
        if("<?= $respuesta ?>" !== "" ){
            if("<?= $respuesta ?>" === "error_estado"){
                Swal.fire({
                    position: 'top-end',
                    width:300,
                    icon: 'error',
                    text: 'El usuario no se encuentra activo',
                    showConfirmButton: false,
                    timer: 2000
                })
            }else if("<?= $respuesta ?>" === "error_usuario"){
                Swal.fire({
                    position: 'top-end',
                    width:300,
                    icon: 'error',
                    text: 'Usuario y/o contraseña incorrectos',
                    showConfirmButton: false,
                    timer: 2000
                })
            }

        }
    });
</script>
</body>
</html>




