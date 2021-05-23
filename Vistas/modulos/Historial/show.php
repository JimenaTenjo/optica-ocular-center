<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: ../Persona/login.php');
    exit;
}
require("../../partials/routes.php");
require("../../../App/Controlador/ExamenHistorialControlador.php");
require("../../../App/Controlador/HistorialControlador.php");
use App\Controlador\HistorialControlador;
use App\Controlador\ExamenHistorialControlador;

if(!empty($_GET["id"]) && isset($_GET["id"])) {
    $dataHistorial = HistorialControlador::searchForID($_GET["id"]);
    $dataCita = $dataHistorial->getCitasHistorialId();
    $arrayExamenes = ExamenHistorialControlador::filterByCitaId($dataCita->getIdCita());
    if(!empty($_GET["formula"]) && isset($_GET["formula"])){
        $formula = $_GET["formula"];
    }else{
        $formula = "";
    }
}else{
    $dataHistorial = null;
    $formula = "";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= getenv('TITLE_SITE') ?> | Ver Cita</title>
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
                        <h1>Ver historial</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/Vistas/">Optica Ocular Center</a></li>
                            <li class="breadcrumb-item active">Historial</li>
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
                        Error al crear el historial: <?= $_GET['mensaje'] ?>
                    </div>
                <?php } ?>
            <?php } ?>


            <!-- Horizontal Form -->
                <?php if($dataHistorial!=null){
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Información cita</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#exampleModal" >
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="last_name">Fecha</label>
                                                    <input type="text" class="form-control" value="<?= $dataCita->getFecha() ?>"  readonly>
                                                    <input type="text" class="form-control" name="citas_historial_id" value="<?= $dataCita->getIdCita() ?>"  hidden required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="last_name">Hora</label>
                                                    <input type="text" class="form-control" value="<?= $dataCita->getHora() ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="last_name">Documento</label>
                                                    <input type="text" class="form-control"
                                                           value="<?= $dataCita->getPacienteCitaId()->getIdPersonaPaciente()->getNumeroDocumento() ?>"
                                                           readonly>
                                                    <input type="text" class="form-control" name="id_paciente_cita" value="<?= $dataCita->getPacienteCitaId()->getIdPaciente() ?>" hidden required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="last_name">Nombres y apellidos</label>
                                                    <input type="text" class="form-control"
                                                           value="<?= $dataCita->getPacienteCitaId()->getIdPersonaPaciente()->getFullName() ?>"
                                                           readonly
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="last_name">Motivo cita</label>
                                                    <input type="text" class="form-control"
                                                           value="<?= $dataCita->getMotivoConsultaid()->getDescripcion() ?>"
                                                           readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>

                            <div class="col-md-6">
                                <div class="card card-info card-border">
                                    <div class="card-header">
                                        <h3 class="card-title">Información acudiente</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <div class="card-body">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="last_name">Nombre acudiente</label>
                                                <input type="text" class="form-control" value="<?= $dataHistorial->getNombreAcudiente() ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="last_name">Teléfono acudiente</label>
                                                <input type="text" class="form-control" value="<?= $dataHistorial->getTelefonoAcudiente() ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="last_name">Parentezco</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>

                        <div class="card card-info card-border">
                            <div class="card-header">
                                <h3 class="card-title">Exámenes</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" onclick="get_examenes_historial()">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped" id="table_examenes_historial">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Id examen</th>
                                                <th>Nombre examen</th>
                                                <th>Descripcion examen</th>
                                                <th>Acciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $index = 1;
                                            if($dataHistorial->getPrescripcionHistorialId()!=null){
                                                $index = 2;
                                                ?>
                                                <tr>
                                                    <td>1</td>
                                                    <td><?= $dataHistorial->getPrescripcionHistorialId()->getIdPrescripcionFinal() ?></td>
                                                    <td>Prescripcion final</td>
                                                    <td>Prescripcion final</td>
                                                    <td style="text-align: center">
                                                        <button class="btn btn-warning btn-sm"  data-toggle="modal" data-target="#examen_prescripcion" >
                                                            <i class="fas fa-eye"></i>Ver
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="card card-info card-border">
                            <div class="card-header">
                                <h3 class="card-title">Datos historial</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Anamnesis</label>
                                            <input type="text" class="form-control" value="<?= $dataHistorial->getAnamnesis() ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Antedecedentes</label>
                                            <input type="text" class="form-control" value="<?= $dataHistorial->getAntecedentes() ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Código RIPS</label>
                                            <input type="text" class="form-control" value="<?= $dataHistorial->getCodigoRips() ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Conducta</label>
                                            <input type="text" class="form-control" value="<?= $dataHistorial->getConducta() ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="control">Control</label>
                                            <textarea  class="form-control" readonly><?= $dataHistorial->getControl() ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="diagnostico">Diagnostico</label>
                                            <textarea class="form-control" readonly><?= $dataHistorial->getDiagnostico() ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Error!</h5>
                            No se encontro ningun registro con estos parametros de busqueda <?= ($_GET['mensaje']) ?? "" ?>
                        </div>
                    <?php } ?>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php
        if($dataHistorial->getPrescripcionHistorialId()!=null){
            $prescripcion_final = $dataHistorial->getPrescripcionHistorialId();
            ?>
            <div class="modal fade bd-example-modal-lg" id="examen_prescripcion" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><strong>Examen prescripcion final</strong></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
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
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    ?>

    <?php require ('../../partials/footer.php');?>
</div>
<!-- ./wrapper -->
<?php require ('../../partials/scripts.php');?>

<script>
    function eliminar_examen_historial(id){
        $.ajax({
            data: {'examen_historial_id':id},
            url:    '../../../App/Controlador/ExamenHistorialControlador.php?action=eliminar',
            type: 'post',
            beforeSend: function () {
                console.log("before")
            },
            success: function (response_json) {
                console.log(response_json)
                get_examenes_historial();
            }
        });
    }

    function get_examenes_historial() {
        var start_index = "<?= $index ?>";

        $.ajax({
            data: {'cita_id':'<?= $_GET["id"] ?>'},
            url:    '../../../App/Controlador/ExamenHistorialControlador.php?action=exmanesHistorialJson',
            type: 'post',
            beforeSend: function () {
                console.log("before")
            },
            success: function (response_json) {
                var response = JSON.parse(response_json);
                let tiene_prescripcion = "<?= $dataHistorial->getPrescripcionHistorialId() != null ? 1 : 0?>";

                if(tiene_prescripcion === "1"){
                    $('#table_examenes_historial > tbody > tr').find('tr:gt(0)').remove()
                }else{
                    console.log(0)
                    $('#table_examenes_historial > tbody > tr').remove()
                }

                $.each(response.data, function(index, element) {
                    var htmlTags = '<tr>'+
                        '<td>' + start_index + '</td>'+
                        '<td>' + element["id_examen_historial"] + '</td>'+
                        '<td>' + element["nombre_examen"] + '</td>'+
                        '<td>' + element["descripcion_examen"] + '</td>'+
                        '<td style="text-align: center">  <a href="../ExamenHistorial/show.php?id='+ element["id_examen_historial"] +'" class="btn btn-warning btn-sm" target="_blank">' +
                        ' <i class="fas fa-eye"></i> Ver </a>'+
                        '  <a href="../ExamenHistorial/edit.php?id='+ element["id_examen_historial"] +'" class="btn btn-info btn-sm" target="_blank">' +
                        ' <i class="fas fa-pencil-alt"></i> Editar </a>'+
                        '  <button onclick="eliminar_examen_historial('+ element["id_examen_historial"] +')" class="btn btn-danger btn-sm" >' +
                        ' <i class="fas fa-trash"></i> Elimnar </button></td>'+
                        '</tr>';
                    $('#table_examenes_historial > tbody').append(htmlTags);
                    start_index ++;
                });
            }
        });
    }

    function registrar_formula_medica(descripcion){
        let id_prescripcion_formula = '<?= $dataHistorial->getPrescripcionHistorialId()!=null?$dataHistorial->getPrescripcionHistorialId()->getIdPrescripcionFinal():"" ?>';
        $.ajax({
            data: {'descripcion':descripcion,'id_prescripcion_formula':id_prescripcion_formula},
            url:    '../../../App/Controlador/FormulaMedicaControlador.php?action=create',
            type: 'post',
            beforeSend: function () {
                console.log("before")
            },
            success: function (response_json) {
                var response = JSON.parse(response_json)
                if(response["id"]){
                    Swal.fire({
                        title: response["mensaje"],
                        text: "¿ Desea ver fórmula médica ?",
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.value) {
                            window.open('../FormulaMedica/show.php?id='+response["id"], '_blank');
                        }
                    });
                }else{
                    Swal.fire({
                            icon: 'error',
                            title: response["mensaje"],
                            timer: 2000
                    })
                }
            }
        });
    }



    $( document ).ready(function() {

        Swal.fire({
            title: 'Registro creado correctamente',
            text: "¿ Desea crear fórmula médica ?",
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.value) {
                Swal.fire({
                    title: 'Registrar fórmula médica',
                    html: `<textarea id="descripcion" class="swal2-input" placeholder="Descripcion"></textarea>`,
                    confirmButtonText: 'Registrar',
                    focusConfirm: false,
                    preConfirm: () => {
                        const descripcion = Swal.getPopup().querySelector('#descripcion').value
                        if (!descripcion) {
                            Swal.showValidationMessage(`Por favor ingrese una descripcion`)
                        }
                        return { descripcion: descripcion }
                    }
                }).then((result) => {
                    registrar_formula_medica(result.value.descripcion);
                })
            }
        });




        $("#table_examenes_historial").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "language": {
                "url": "../../components/Spanish.json" //Idioma
            },
        });

        if("<?= $formula ?>" !== ''){

        }
        get_examenes_historial();

    });
</script>

</body>
</html>