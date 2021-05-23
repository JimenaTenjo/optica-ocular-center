<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: ../Persona/login.php');
    exit;
}
require("../../partials/routes.php");
require("../../../App/Controlador/FormulaMedicaControlador.php");
use App\Controlador\FormulaMedicaControlador;
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= getenv('TITLE_SITE') ?> | Ver fórmula médica</title>
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
                        <h1>Ver cita</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/Vistas/">Optica Ocular Center</a></li>
                            <li class="breadcrumb-item active">Fórmula médica</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Horizontal Form -->
            <div class="card card-info">
                <?php if(!empty($_GET["id"]) && isset($_GET["id"])){
                    $dataFormulaMedica = FormulaMedicaControlador::searchForID($_GET["id"]);
                    if(!empty($dataFormulaMedica)){
                        ?>
                        <div class="card-header">
                            <h3 class="card-title">Fórmula médica</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fecha</label>
                                        <input type="text" class="form-control" value="<?= $dataFormulaMedica->getFecha() ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <?php $prescripcion_final = $dataFormulaMedica->getIdPrescripcionFormula() ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">OD</label>
                                        <input type="text" class="form-control" value="<?= $prescripcion_final->getOD() ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">ADD OD</label>
                                        <input type="text" class="form-control" value="<?= $prescripcion_final->getADDOD() ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">AV VL OD</label>
                                        <input type="text" class="form-control" value="<?= $prescripcion_final->getAVVLOD() ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">AV VP OD</label>
                                        <input type="text" class="form-control" value="<?= $prescripcion_final->getAVVPOD() ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">DNP OD</label>
                                        <input type="text" class="form-control" value="<?= $prescripcion_final->getDNPOD() ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">OI</label>
                                        <input type="text" class="form-control" value="<?= $prescripcion_final->getOI() ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">ADD OI</label>
                                        <input type="text" class="form-control" value="<?= $prescripcion_final->getADDOI() ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">AV VL OI</label>
                                        <input type="text" class="form-control" value="<?= $prescripcion_final->getAVVLOI() ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">AV VP OI</label>
                                        <input type="text" class="form-control" value="<?= $prescripcion_final->getAVVPOI() ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">DNP OI</label>
                                        <input type="text" class="form-control" value="<?= $prescripcion_final->getDNPOI() ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="last_name">Descripción</label>
                                    <textarea class="form-control" readonly><?= $dataFormulaMedica->getDescripcion() ?></textarea>
                                </div>
                            </div>

                        </div>
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

</body>
</html>