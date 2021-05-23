<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: ../Persona/login.php');
    exit;
}

require("../../partials/routes.php");
require("../../../App/Controlador/CitaControlador.php");
require("../../../App/Controlador/MedicoControlador.php");
require("../../../App/Controlador/PacienteControlador.php");
require("../../../App/Controlador/ExamenHistorialControlador.php");
use App\Controlador\CitaControlador;
use App\Controlador\MedicoControlador;
use App\Controlador\PacienteControlador;
use App\Controlador\ExamenHistorialControlador;


$citas = count(CitaControlador::getAll());
$medicos = count(MedicoControlador::getAll());
$pacientes = count(PacienteControlador::getAll());
$examenes = count(ExamenHistorialControlador::getAll());
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= getenv('TITLE_SITE') ?> | Dashboard</title>
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
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?= $medicos ?></h3>
                                <p>Medicos</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-medical"></i>
                            </div>
                            <a href="#" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?= $pacientes ?></h3>
                                <p>Pacientes</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-android-person"></i>
                            </div>
                            <a href="#" class="small-box-footer">Más inforamción <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?= $citas ?></h3>
                                <p>Citas</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-android-calendar"></i>
                            </div>
                            <a href="../Cita/index.php" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?= $examenes ?></h3>
                                <p>Examenes</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-erlenmeyer-flask"></i>
                            </div>
                            <a href="#" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->

                <!-- Card list quotes -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Citas de hoy</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="tblDashboard" class="datatable table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Medico</th>
                                        <th>Paciente</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $arrCitas = CitaControlador::filterToDay();
                                    foreach ($arrCitas as $cita){
                                        ?>
                                        <tr>
                                            <td><?php echo $cita->getIdCita(); ?></td>
                                            <td><?php echo $cita->getFecha(); ?></td>
                                            <td><?php echo $cita->getHora(); ?></td>
                                            <td><?php echo $cita->getMedicoCitaId()->getPersonaMedico()->getFullName()?></td>
                                            <td><?php echo $cita->getPacienteCitaId()->getIdPersonaPaciente()->getFullName() ?></td>
                                            <td><?php echo $cita->getEstado(); ?></td>
                                            <td style="text-align: center">
                                                <a class="btn btn-success btn-sm" href="../Historial/create.php?id_cita=<?php echo $cita->getIdCita(); ?>">
                                                    <i class="fas fa-sign-in-alt">
                                                    </i>
                                                    Ingresar
                                                </a>
                                                <a class="btn btn-danger btn-sm" href="../../../App/Controlador/CitaControlador.php?action=inactivateFromDashboard&IdCita=<?php echo $cita->getIdCita(); ?>">
                                                    <i class="fas fa-times">
                                                    </i>
                                                    Cancelar
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- ./card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>

            </div><!-- /.container-fluid -->
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

        $("#tblDashboard").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "language": {
                "url": "../../components/Spanish.json" //Idioma
            },
        });
    });
</script>
</body>
</html>