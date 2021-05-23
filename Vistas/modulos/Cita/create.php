<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: ../Persona/login.php');
    exit;
}

require("../../partials/routes.php");
require("../../../App/Modelo/Medico.php");
require("../../../App/Modelo/MotivoConsulta.php");
use App\Modelo\Medico;
use App\Modelo\MotivoConsulta;
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= getenv('TITLE_SITE') ?> | Crear Cita</title>
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
                        <h1>Crear cita</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/Vistas/">Optica Ocular Center</a></li>
                            <li class="breadcrumb-item active">Cita</li>
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
                        Error al crear la cita: <?= $_GET['mensaje'] ?>
                    </div>
                <?php } ?>
            <?php } ?>


            <!-- Horizontal Form -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Información cita</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post" id="frmCreatepersona" name="frmCreateCita" action="../../../App/Controlador/CitaControlador.php?action=create">
                    <?php
                        $arrayMedicos = Medico::getAll();
                        $arrayMotivos = MotivoConsulta::getAll();
                    ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                          </span>
                                        </div>
                                        <input type="text" class="form-control float-right" id="fecha" name="fecha" required>

                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hora</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            <i class="far fa-clock"></i>
                                          </span>
                                        </div>
                                        <select class="form-control" id="hora" name="hora" required >
                                            <option value="" selected disabled>Seleccionar</option>
                                        </select>
                                        <div class="input-group-prepend">
                                            <span class="spinner-border spinner-border-sm" id="loading_hours" style="display: none"></span>
                                        </div>
                                    </div>
                                    <!-- /.input group -->

                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Documento del paciente</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="id_paciente_cita" name="id_paciente_cita" hidden required>
                                        <input type="text" class="form-control" id="documento_paciente" name="documento_paciente" placeholder="Ingrese el documento del paciente" required>
                                        <div class="input-group-prepend">
                                            <span class="spinner-border spinner-border-sm" id="loading_document" style="display: none"></span>
                                        </div>
                                    </div>
                                    <div class="bg-danger disabled color-palette" id="error_documento" style="display: none"><span>Documento no encontrado</span></div>

                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Nombre del paciente</label>
                                    <input type="text" class="form-control" id="nombre_paciente"  required readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Médico</label>
                                    <select class="form-control" id="id_medico_cita" name="id_medico_cita" required >
                                        <option value="" selected disabled>Seleccionar</option>
                                        <?php
                                            foreach ($arrayMedicos as $medico){
                                                echo '<option value="'. $medico->getIdMedico().'">'.$medico->getPersonaMedico()->getNombres().' '.$medico->getPersonaMedico()->getApellidos().'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Motivo consulta</label>
                                    <select class="form-control" id="id_motivo_cita" name="id_motivo_cita" required >
                                        <option value="" selected disabled>Seleccionar</option>
                                        <?php
                                        foreach ($arrayMotivos as $motivo){
                                            echo '<option value="'. $motivo->getIdMotivoConsulta().'">'.$motivo->getDescripcion().'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                        <button type="submit" class="btn btn-info float-right">Crear</button>
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

        var horario = ["08:00:00","08:30:00","09:00:00","09:30:00","10:00:00","10:30:00","11:00:00","11:30:00","12:00:00","12:30:00","13:00:00"
            ,"13:30:00","14:00:00","14:30:00","15:00:00","15:30:00","16:00:00","16:30:00","17:00:00","17:30:00"];
        var startDate = moment().format('YYYY-MM-DD');

        $('#fecha').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'YYYY-MM-DD'
            },
            startDate: startDate
        }, function(start, end, label) {
            horario_disponible(start.format('YYYY-MM-DD'))
        });

        $("#documento_paciente").blur(function(){
            buscar_paciente(this.value)
        });

        function buscar_paciente(documento_paciente) {
            if(documento_paciente!==""){
                $.ajax({
                    data: {'documento_paciente':documento_paciente},
                    url: '../../../App/Controlador/PacienteControlador.php?action=searchPatientForDocument',
                    type: 'post',
                    beforeSend: function () {
                        $('#loading_document').show()
                    },
                    success: function (response) {
                        $('#loading_document').hide()
                        if(response !== ""){
                            var paciente = JSON.parse(response)
                            $('#error_documento').hide(300)
                            $('#nombre_paciente').val(paciente.nombre)
                            $('#id_paciente_cita').val(paciente.id)
                        }else{
                            $('#error_documento').show(300)
                            $('#nombre_paciente').val("")
                        }
                    }
                });
            }
        }
        
        function horario_disponible(fecha) {
            $.ajax({
                data: {'fecha_cita':fecha},
                url: '../../../App/Controlador/CitaControlador.php?action=searchAvailableHours',
                type: 'post',
                beforeSend: function () {
                    $('#loading_hours').show()
                },
                success: function (response) {
                    $('#hora').find('option').remove().end().append('<option value="" selected disabled>Seleccionar</option>');
                    var horario_ocupado = JSON.parse(response);
                    console.log(horario_ocupado)
                    $.each(horario, function( index, value ) {
                        if(horario_ocupado.indexOf(value)<0){
                            $('#hora').append($('<option>', {
                                value: value,
                                text : value
                            }));
                        }
                    });
                    $('#loading_hours').hide()
                }
            });
        }

        horario_disponible(startDate)

    });
</script>
</body>
</html>