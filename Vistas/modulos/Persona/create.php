<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: ../Persona/login.php');
    exit;
}

require("../../partials/routes.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title><?= getenv('TITLE_SITE') ?> | Crear Persona</title>
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
                        <h1>Crear persona</h1>
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
                        Error al crear el usuario: <?= $_GET['mensaje'] ?>
                    </div>
                <?php } ?>
            <?php } ?>


            <!-- Horizontal Form -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Persona</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post" id="frmCreatepersona" name="frmCreatepersona" action="../../../App/Controlador/PersonaControlador.php?action=create">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tipo documento</label>
                                    <select class="form-control" id="tipo_documento" name="tipo_documento" required >
                                        <option value=""  selected disabled>Seleccionar</option>
                                        <option value="TARJETA DE IDENTIDAD">Tarjeta de Identidad</option>
                                        <option value="CEDULA DE CIUDADANIA">Cedula de Ciudadania</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Número documento</label>
                                    <input type="number" class="form-control" id="numero_documento" name="numero_documento" placeholder="Ingrese el numero de documento" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nombres</label>
                                    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Ingrese los nombres" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Ingrese los apellidos" required>
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
                                        <input type="text" class="form-control float-right" id="fecha_nacimiento" name="fecha_nacimiento" required>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="genero">Género</label>
                                    <select class="form-control" id="genero" name="genero" required>
                                        <option value=""  selected disabled>Seleccionar</option>
                                        <option value="MASCULINO">Masculino</option>
                                        <option value="FEMENINO">Femenino</option>
                                        <option value="OTRO">Otro</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <input type="number" class="form-control" id="telefono" name="telefono" placeholder="Ingrese el número de teléfono" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ingrese la dirección" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ciudad">Ciudad</label>
                                    <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="Ingrese el nombre de la ciudad" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rol">Rol</label>
                                    <select id="rol" name="rol" class="form-control" required>
                                        <option value=""  selected disabled>Seleccionar</option>
                                        <option value="MEDICO">Medico</option>
                                        <option value="SECRETARIA">Secretaria</option>
                                        <option value="PACIENTE">Paciente</option>
                                        <option value="ADMINISTRADOR">Administrador</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!--  DATOS EXCLUSIVAMENTE DEL PACIENTE-->
                        <div id="paciente" style="display: none">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono">Ocupación</label>
                                        <input type="text" class="form-control" id="ocupacion" name="ocupacion" placeholder="Ingrese la ocupación">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="direccion">Estado civil</label>
                                        <select name="estado_civil" id="estado_civil" class="form-control">
                                            <option value="" selected disabled>Seleccionar</option>
                                            <option value="soltero">Soltero</option>
                                            <option value="casado">Casado</option>
                                            <option value="union_libre">Unión libre</option>
                                            <option value="viudo">Viudo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono">Tipo afiliación</label>
                                        <select name="tipo_afiliacion" id="tipo_afiliacion" class="form-control">
                                            <option value="" selected disabled>Seleccionar</option>
                                            <option value="beneficiario">Beneficiario</option>
                                            <option value="contributivo">Contributivo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="direccion">Tipo vinculación</label>
                                        <input type="text" class="form-control" id="tipo_vinculacion" name="tipo_vinculacion" placeholder="Ingrese la dirección" >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--  DATOS EXCLUSIVAMENTE DEL MÉDICO-->
                        <div id="medico" style="display: none">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono">Especialización</label>
                                        <input type="text" class="form-control" id="especializacion" name="especializacion" placeholder="Ingrese la especialización">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="direccion">Matrícula profesional</label>
                                        <input type="text" class="form-control" id="licencia" name="licencia" placeholder="Ingrese la licencian" >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese el correo electrónico" required>
                                </div>
                            </div>
                            <div class="col-md-6" style="display: none" id="password">
                                <div class="form-group">
                                    <label for="contrasena">Contraseña</label>
                                    <input type="text" class="form-control" id="contrasena" name="contrasena" placeholder="Ingrese la contraseña" >
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
            showDropdowns: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
        })

        $('#rol').on('change', function () {
            $('#paciente').hide(500)
            $('#medico').hide(500)
            if(this.value !== "PACIENTE" ){
                if(this.value == "MEDICO"){
                    $('#medico').show(500)
                    camposObliatoriosPaciente(false)
                }
                $('#password').show(500)
            }else{
                $('#paciente').show(500)
                $('#password').hide(500)
                camposObliatoriosPaciente(true)

            }
        });

        function camposObliatoriosPaciente(value) {
            if(value){
                $("#ocupacion").prop('required',true);
            }else{
                $("#ocupacion").prop('required',false);
            }

        }
        function camposObliatoriosMedico(value) {
            if(value==="activar"){

            }else{

            }
        }
    });
</script>
</body>
</html>