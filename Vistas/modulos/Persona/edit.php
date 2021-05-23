<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: ../Persona/login.php');
    exit;
}
require("../../partials/routes.php");
require("../../../App/Controlador/PersonaControlador.php");
use App\Controlador\PersonaControlador;
?>


<!DOCTYPE html>
<html>
<head>
    <title><?= getenv('TITLE_SITE') ?> | Editar Persona</title>
    <?php require("../../partials/head_imports.php"); ?>
</head>
<body class="hold-transition sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">
    <?php require("../../partials/navbar_customization.php"); ?>

    <?php require("../../partials/sliderbar_main_menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editar persona</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/Vistas/">Optica Ocular Center</a></li>
                            <li class="breadcrumb-item active">Persona</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <?php if(!empty($_GET['respuesta'])){ ?>
                <?php if ($_GET['respuesta'] != "correcto"){ ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                        Error al editar el usuario: <?= $_GET['mensaje'] ?>
                    </div>
                <?php } ?>
            <?php } ?>


            <!-- Horizontal Form -->
            <div class="card card-info">
                <?php if(!empty($_GET["id"]) && isset($_GET["id"])){
                $dataPersona = PersonaControlador::searchForID($_GET["id"]);
                if(!empty($dataPersona)){
                ?>

                <div class="card-header">
                    <h3 class="card-title">Persona</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post" id="frmEditpersona" name="frmEditpersona" action="../../../App/Controlador/PersonaControlador.php?action=edit">
                        <input id="idPersona" name="idPersona" value="<?php echo $dataPersona->getIdPersona(); ?>" hidden required="required" type="text">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tipo documento</label>
                                        <select class="form-control" id="tipo_documento" name="tipo_documento" required >
                                            <option value=""  disabled>Seleccionar</option>
                                            <option value="TARJETA DE IDENTIDAD"
                                                <?= ($dataPersona->getTipoDocumento() == "TARJETA DE IDENTIDAD") ? "selected":""; ?>>Tarjeta de Identidad
                                            </option>
                                            <option value="CEDULA DE CIUDADANIA"
                                                <?= ($dataPersona->getTipoDocumento() == "CEDULA DE CIUDADANIA") ? "selected":""; ?>> Cedula de Ciudadania
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Número documento</label>
                                        <input type="number" class="form-control" id="numero_documento" name="numero_documento"
                                               placeholder="Ingrese el numero de documento" required value="<?= $dataPersona->getNumeroDocumento() ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nombres</label>
                                        <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Ingrese los nombres" required
                                               value="<?= $dataPersona->getNombres() ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Apellidos</label>
                                        <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Ingrese los apellidos" required
                                               value="<?= $dataPersona->getApellidos() ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Fecha de nacimiento</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                              </span>
                                            </div>
                                            <input type="text" class="form-control float-right" id="fecha_nacimiento" name="fecha_nacimiento" required
                                                   value="<?= $dataPersona->getFechaNacimiento() ?>">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="genero">Género</label>
                                        <select class="form-control" id="genero" name="genero" required>
                                            <option value=""  disabled>Seleccionar</option>
                                            <option value="MASCULINO" <?= ($dataPersona->getGenero() == "MASCULINO") ? "selected":""; ?>>Masculino</option>
                                            <option value="FEMENINO" <?= ($dataPersona->getGenero() == "FEMENINO") ? "selected":""; ?>>Femenino</option>
                                            <option value="OTRO" <?= ($dataPersona->getGenero() == "OTRO") ? "selected":""; ?>>Otro</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono">Teléfono</label>
                                        <input type="number" class="form-control" id="telefono" name="telefono" placeholder="Ingrese el número de teléfono" required
                                               value="<?= $dataPersona->getTelefono() ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="direccion">Dirección</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ingrese la dirección"
                                               value="<?= $dataPersona->getDireccion() ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ciudad">Ciudad</label>
                                        <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="Ingrese el nombre de la ciudad" required
                                               value="<?= $dataPersona->getCiudad() ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rol">Rol</label>
                                        <select id="rol" name="rol" class="form-control">
                                            <option value=""  disabled>Seleccionar</option>
                                            <option value="MEDICO" <?= ($dataPersona->getRol() == "MEDICO") ? "selected":""; ?>>Medico</option>
                                            <option value="SECRETARIA" <?= ($dataPersona->getRol() == "SECRETARIA") ? "selected":""; ?>>Secretaria</option>
                                            <option value="PACIENTE" <?= ($dataPersona->getRol() == "PACIENTE") ? "selected":""; ?>>Paciente</option>
                                            <option value="ADMINISTRADOR" <?= ($dataPersona->getRol() == "ADMINISTRADOR") ? "selected":""; ?>>Administrador</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese el correo electrónico" required
                                               value="<?= $dataPersona->getEmail() ?>">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">Enviar</button>
                            <button type="submit" class="btn btn-default float-right">Cancelar</button>
                        </div>
                        <!-- /.card-footer -->
                </form>
                <?php }else{ ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                        No se encontro ningun registro con estos parametros de busqueda <?= ($_GET['mensaje']) ?? "" ?>
                    </div>
                <?php }
                } ?>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php require ('../../partials/footer.php');?>
</div>
<!-- ./wrapper -->
<?php require ('../../partials/scripts.php');?>
<script>
    $(document).ready(function() {
        $('#fecha_nacimiento').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
        })
        $('#rol').on('change', function () {
            if(this.value !== "PACIENTE" ){
                $('#password').show(500)
            }else{
                $('#password').hide(500)
            }
        });
        $('#rol').trigger("change");
    });
</script>
</body>
</html>