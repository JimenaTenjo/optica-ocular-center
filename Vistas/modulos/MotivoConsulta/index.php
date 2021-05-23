<?php

session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: ../Persona/login.php');
    exit;
}
require("../../partials/routes.php");
require("../../../App/Controlador/MotivoConsultaControlador.php");

use App\Controlador\MotivoConsultaControlador;
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= getenv('TITLE_SITE') ?> | Motivos Consulta</title>
    <?php require("../../partials/head_imports.php"); ?>
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= $adminlteURL ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?= $adminlteURL ?>/plugins/datatables-responsive/css/responsive.bootstrap4.css">
    <link rel="stylesheet" href="<?= $adminlteURL ?>/plugins/datatables-buttons/css/buttons.bootstrap4.css">
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
                        <h1>Motivos Consulta</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/Vistas/">optica-ocular-center</a></li>
                            <li class="breadcrumb-item active">Inicio</li>
                            <li class="breadcrumb-item active">Motivos Consulta</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <?php if(!empty($_GET['respuesta']) && !empty($_GET['action'])){ ?>
                <?php if ($_GET['respuesta'] == "correcto"){ ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Correcto!</h5>
                        <?php if ($_GET['action'] == "create"){ ?>
                            El motivo ha sido creado con exito!
                        <?php }else if($_GET['action'] == "update"){ ?>
                            Los datos del motivo han sido actualizados correctamente!
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php } ?>

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gestionar Motivos Consulta</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto mr-auto"></div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#createMotivoModal" style="margin-right: 5px;">
                                <i class="fas fa-plus"></i> Crear Motivo
                            </button>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px">
                        <div class="col">
                            <table id="tblExamen" class="datatable table table-bordered table-striped" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Descripcion</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $arrMotivos = MotivoConsultaControlador::getAll();
                                foreach ($arrMotivos as $key =>$motivo){
                                    ?>
                                    <tr>
                                        <td><?= $key+1 ?></td>
                                        <td><?= $motivo->getDescripcion(); ?></td>
                                        <td><?= $motivo->getEstado(); ?></td>
                                        <td>

                                            <button type="button" data-toggle="modal" data-target="#editMotivo_<?= $motivo->getIdMotivoConsulta()?>" title="Actualizar" class="btn docs-tooltip btn-primary btn-xs"><i class="fa fa-edit"></i></button>
                                            <button type="button" data-toggle="modal" data-target="#verMotivo_<?= $motivo->getIdMotivoConsulta()?>" title="Ver" class="btn docs-tooltip btn-warning btn-xs"><i class="fa fa-eye"></i></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Modal Create -->

    <div class="modal fade" id="createMotivoModal" tabindex="-1" role="dialog" aria-labelledby="createMotivoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="form-horizontal" method="post" id="frmCreateExamen" name="frmCreateExamen" action="../../../App/Controlador/MotivoConsultaControlador.php?action=create">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Crear Motivo Consulta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nombre">Descripcion</label>
                                    <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Ingrese la descripción" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="estado">Estado</label>
                                    <select name="estado" id="estado" class="form-control">
                                        <option value="Activo">Activo</option>
                                        <option value="Inactivo">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    foreach ($arrMotivos as $motivo){
        ?>
        <div class="modal fade" id="verMotivo_<?= $motivo->getIdMotivoConsulta() ?>" tabindex="-1" role="dialog" aria-labelledby="createExamenModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ver motivo consulta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Descripcion</label>
                                    <input type="text" class="form-control" value="<?= $motivo->getDescripcion() ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Estado</label>
                                    <input type="text" class="form-control"  readonly value="<?= $motivo->getEstado() ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

    <?php
    foreach ($arrMotivos as $motivo){
        ?>
        <div class="modal fade" id="editMotivo_<?= $motivo->getIdMotivoConsulta()?>" tabindex="-1" role="dialog" aria-labelledby="createExamenModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form class="form-horizontal" method="post" id="frmCreateExamen" name="frmEditExamen" action="../../../App/Controlador/MotivoConsultaControlador.php?action=edit">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar motivo consulta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="last_name">Descripcion</label>
                                        <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Ingrese el nombre" required value=" <?= $motivo->getDescripcion() ?>">
                                        <input type="text" class="form-control" name="idMotivoConsulta" value="<?= $motivo->getIdMotivoConsulta() ?>" hidden required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="last_name">Estado</label>
                                        <select name="estado" id="estado" class="form-control">
                                            <option value="Activo" <?= $motivo->getEstado()=='Activo'?'selected':''?>>Activo</option>
                                            <option value="Inactivo"  <?= $motivo->getEstado()=='Inactivo'?'selected':''?>>Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
    ?>

    <?php require ('../../partials/footer.php');?>
</div>
<!-- ./wrapper -->
<?php require ('../../partials/scripts.php');?>
<!-- DataTables -->
<script src="<?= $adminlteURL ?>/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= $adminlteURL ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?= $adminlteURL ?>/plugins/datatables-responsive/js/dataTables.responsive.js"></script>
<script src="<?= $adminlteURL ?>/plugins/datatables-responsive/js/responsive.bootstrap4.js"></script>
<script src="<?= $adminlteURL ?>/plugins/datatables-buttons/js/dataTables.buttons.js"></script>
<script src="<?= $adminlteURL ?>/plugins/datatables-buttons/js/buttons.bootstrap4.js"></script>
<script src="<?= $adminlteURL ?>/plugins/jszip/jszip.js"></script>
<script src="<?= $adminlteURL ?>/plugins/pdfmake/pdfmake.js"></script>
<script src="<?= $adminlteURL ?>/plugins/datatables-buttons/js/buttons.html5.js"></script>
<script src="<?= $adminlteURL ?>/plugins/datatables-buttons/js/buttons.print.js"></script>
<script src="<?= $adminlteURL ?>/plugins/datatables-buttons/js/buttons.colVis.js"></script>

<script>
    $( document ).ready(function() {
        $("#tblMotivoConsulta").DataTable({
            "responsive": true,
            "lengthChange": true,
            "language": {
                "url": "../../components/Spanish.json" //Idioma
            },
        });
    });
</script>

</body>
</html>
