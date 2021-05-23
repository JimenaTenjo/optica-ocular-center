<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: ../Persona/login.php');
    exit;
}

require("../../partials/routes.php");
require("../../../App/Controlador/ExamenHistorialControlador.php");
require("../../../App/Controlador/ExamenControlador.php");

use App\Controlador\ExamenControlador;
use App\Controlador\ExamenHistorialControlador;
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= getenv('TITLE_SITE') ?> | Editar Examen historial</title>
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
                        <h1>Editar examen historial</h1>
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
                        Error al actualizar el examen: <?= $_GET['mensaje'] ?>
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
                            <h3 class="card-title">Información examen historial</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Tipo exámen</label>
                                        <select class="form-control" name="" id="examen_id">
                                            <option value="" disabled> Seleccionar</option>
                                            <?php
                                                foreach (ExamenControlador::getAll() as $examen){
                                                    $selected= $examen->getIdExamenes()==$dataExamenHistorial->getExamenId()->getIdExamenes()?"selected":"";
                                                    echo '<option value="'. $examen->getIdExamenes().'"'.$selected.'>'.ucfirst($examen->getNombre()).'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="edit_examen">
                                <?php
                                foreach (json_decode($dataExamenHistorial->getValores()) as $valor_examen){
                                    ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name"><?= $valor_examen->name ?></label>
                                            <input type="text" class="form-control" name="<?= $valor_examen->name ?>" value="<?= $valor_examen->value ?>" >
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="index.php" class="btn btn-default ">Cancelar</a>
                            <button type="button" id="edit" class="btn btn-info float-right">Editar</button>
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
<script>
    $(document).ready(function() {
        var data = [];

        $( "#edit" ).click(function() {
            $("#edit_examen :input").each(function (index,value){
                console.log(index)
                data.push({
                    name:value.name,
                    value:value.value
                })
            });
            console.log(data)
            save_examen(data,<?= $_GET["id"] ?>,$('#examen_id').val());
            data = []
        });

        function save_examen(data, id_examen_historial, examen_id) {

            console.log(data)
            $.ajax({
                data: {'valores':data,'id_examen_historial':id_examen_historial,'examen_id':examen_id},
                url: '../../../App/Controlador/ExamenHistorialControlador.php?action=edit',
                type: 'post',
                beforeSend: function () {
                    console.log("before")
                },
                success: function (response_json) {
                    let response= JSON.parse(response_json);
                    window.location.href = "show.php?id="+id_examen_historial;
                }
            });
        }
    });
</script>
</body>
</html>