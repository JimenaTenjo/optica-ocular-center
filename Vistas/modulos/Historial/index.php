<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: ../Persona/login.php');
    exit;
}

require("../../partials/routes.php");
require("../../../App/Controlador/CitaControlador.php");
require("../../../App/Controlador/HistorialControlador.php");
use App\Controlador\HistorialControlador;
if (!empty($_GET["documento"]) && isset($_GET["documento"])){
    $documento = $_GET["documento"];
}else{
    $documento = '';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= getenv('TITLE_SITE') ?> | Historial</title>
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
                        <h1>Historiales</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/Vistas/">optica-ocular-center</a></li>
                            <li class="breadcrumb-item active">Inicio</li>
                            <li class="breadcrumb-item active">Historial</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="documento">Documento paciente</label>
                        <div class="input-group input-group">
                            <input type="text" id="documento" class="form-control" placeholder="Ingrese el documento del paciente" value="<?= $documento ?>">
                            <span class="input-group-append">
                            <button type="button" class="btn btn-info" id="submit"><i class="fas fa-search"></i> Buscar</button>
                        </span>
                        </div>
                    </div>


                </div>
            </div>
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Lista historial</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="tblHistorial" class="datatable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Nombre acudiente</th>
                                <th>Teléfono acudiente</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                        if ($documento!=''){
                            $arrayHistorial = HistorialControlador::buscarPorDocumentoPaciente($_GET["documento"]);
                        foreach ($arrayHistorial as $key=> $historial){
                            ?>
                            <tr>
                                <td><?= $key ?></td>
                                <td><?php echo $historial->getCitasHistorialId()->getFecha(); ?></td>
                                <td><?php echo $historial->getCitasHistorialId()->getHora(); ?></td>
                                <td><?php echo $historial->getNombreAcudiente(); ?></td>
                                <td><?php echo $historial->getTelefonoAcudiente(); ?></td>
                                <td>
                                    <a href="show.php?id=<?php echo $historial->getIdHistorial(); ?>" type="button" data-toggle="tooltip" title="Ver" class="btn docs-tooltip btn-warning btn-xs"><i class="fa fa-eye"></i></a>
                                    <a href="../../../App/Controlador/HistorialControlador.php?action=generarPdf&id=<?php echo $historial->getIdHistorial(); ?>"
                                       type="button"
                                       target="_blank"
                                       data-toggle="tooltip"
                                       title="Ver"
                                       class="btn docs-tooltip btn-info btn-xs">
                                        <i class="fa fa-file"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } }?>
                        </tbody>
                    </table>
                </div>
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
    $(document).ready(function (){

        $("#tblHistorial").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "language": {
                "url": "../../components/Spanish.json" //Idioma
            },
        });

        $( "#submit" ).click(function() {
            let documento = $('#documento').val();
            if(documento!==""){
                $(location).attr('href','index.php?documento='+documento);
            }else{
                $(location).attr('href','index.php');
            }

        });
    });
</script>

</body>
</html>
