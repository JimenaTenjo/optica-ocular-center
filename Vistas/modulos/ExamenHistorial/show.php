<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: ../Persona/login.php');
    exit;
}
require("../../partials/routes.php");
require("../../../App/Controlador/ExamenHistorialControlador.php");
use App\Controlador\ExamenHistorialControlador;
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= getenv('TITLE_SITE') ?> | Ver examen historial</title>
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
                        <h1>Ver examen</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/Vistas/">Optica Ocular Center</a></li>
                            <li class="breadcrumb-item active">Examen historial</li>
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
                        Error al crear el examen historial: <?= $_GET['mensaje'] ?>
                    </div>
                <?php } ?>
            <?php } ?>


            <!-- Horizontal Form -->
            <div class="card card-info">
                <?php if(!empty($_GET["id"]) && isset($_GET["id"])){
                    $dataExamenHistorial = ExamenHistorialControlador::searchForID($_GET["id"]);
                    if(!empty($dataExamenHistorial)){
                        ?>
                        <div class="card-header">
                            <h3 class="card-title">Examen: <?= ucfirst($dataExamenHistorial->getExamenId()->getNombre())?></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php
                                foreach (json_decode($dataExamenHistorial->getValores()) as $valor_examen){
                                    ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name"><?= $valor_examen->name ?></label>
                                            <input type="text" class="form-control" value="<?= $valor_examen->value ?>" readonly>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-auto mr-auto">
                                    <a role="button" href="index.php" class="btn btn-success float-right" style="margin-right: 5px;">
                                        <i class="fas fa-tasks"></i> Gestionar examen historial
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <a role="button" href="edit.php?id=<?= $dataExamenHistorial->getIdExamenHistorial() ?>" class="btn btn-primary float-right" style="margin-right: 5px;">
                                        <i class="fas fa-plus"></i> Editar examen historial
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-footer -->
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