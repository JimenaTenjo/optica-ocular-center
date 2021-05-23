<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: ../Persona/login.php');
    exit;
}

require("../../partials/routes.php");
require("../../../App/Modelo/Medico.php");
require("../../../App/Modelo/MotivoConsulta.php");
require("../../../App/Controlador/CitaControlador.php");

use App\Controlador\CitaControlador;
use App\Modelo\Medico;
use App\Modelo\MotivoConsulta;
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= getenv('TITLE_SITE') ?> | Editar Cita</title>
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
                        <h1>Editar cita</h1>
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
                <?php if(!empty($_GET["id"]) && isset($_GET["id"])){
                $dataCita = CitaControlador::searchForID($_GET["id"]);
                if(!empty($dataCita)){
                ?>
                    <div class="card-header">
                        <h3 class="card-title">Información cita</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal" method="post" id="frmEditCita" name="frmEditCita" action="../../../App/Controlador/CitaControlador.php?action=edit">
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
                                            <input type="text" class="form-control" id="id_cita" name="id_cita" value="<?= $dataCita->getIdCita() ?>" hidden required>
                                            <input type="text" class="form-control float-right" id="fecha" name="fecha" required value="<?= $dataCita->getFecha() ?>">

                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Hora</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="hora_cita" name="hora_cita" value="<?= $dataCita->getHora() ?>" hidden required>
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
                                            <input type="text" class="form-control" id="id_paciente_cita" name="id_paciente_cita" value="<?php echo $dataCita->getPacienteCitaId()->getIdPaciente(); ?>" hidden required>
                                            <input type="text" class="form-control" id="documento_paciente" name="documento_paciente" value="<?= $dataCita->getPacienteCitaId()->getIdPersonaPaciente()->getNumeroDocumento() ?>" readonly>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Nombre del paciente</label>
                                        <input type="text" class="form-control" id="nombre_paciente" value="<?= $dataCita->getPacienteCitaId()->getIdPersonaPaciente()->getFullName() ?>" readonly>
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
                                                $selected = $medico->getIdMedico() == $dataCita->getMedicoCitaId()->getIdMedico() ? "selected":"sel";
                                                echo '<option '.$selected.' value="'.$medico->getIdMedico().'">'.$medico->getPersonaMedico()->getFullName().'</option>';
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
                                                $selected = $motivo->getIdMotivoConsulta() == $dataCita->getMotivoConsultaid()->getIdMotivoConsulta() ? "selected":"";
                                                echo '<option '.$selected.' value="'.$motivo->getIdMotivoConsulta().'">'.$motivo->getDescripcion().'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="index.php" class="btn btn-default ">Cancelar</a>
                            <button type="submit" class="btn btn-info float-right">Editar</button>
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

        var horario = ["08:00","08:30","09:00","09:30","10:00","10:30","11:00","11:30","12:00","12:30","13:00","13:30","14:00","14:30","15:00","15:30","16:00","16:30","17:00","17:30"];
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
                    var hora_cita = $('#hora_cita').val();
                    $.each(horario, function( index, value ) {
                        if(horario_ocupado.indexOf(value)<0 || value === hora_cita){
                            let selected = value === hora_cita;

                            $('#hora').append($('<option>', {
                                value: value,
                                text : value,
                                selected : selected
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