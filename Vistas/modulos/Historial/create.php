<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: ../Persona/login.php');
    exit;
}
require("../../partials/routes.php");
require("../../../App/Modelo/Cita.php");
require("../../../App/Controlador/CitaControlador.php");
require("../../../App/Controlador/ExamenControlador.php");

use App\Controlador\CitaControlador;
use App\Controlador\ExamenControlador;
use App\Modelo\Cita;
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= getenv('TITLE_SITE') ?> | Crear historial</title>
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
                        <h1>Crear historial</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/Vistas/">Optica Ocular Center</a></li>
                            <li class="breadcrumb-item active">Historial Cita</li>
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

            <?php if(!empty($_GET["id_cita"]) && isset($_GET["id_cita"])){
            $dataCita = CitaControlador::searchForID($_GET["id_cita"]);
            if(!empty($dataCita)){
            ?>
                <form class="form-horizontal" method="post" id="frmCreatepersona" name="frmCreateCita" action="../../../App/Controlador/HistorialControlador.php?action=create">
            <!-- Horizontal Form -->
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
                                            <input type="text" class="form-control" name="nombre_acudiente" required placeholder="Ingrese el nombre">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="last_name">Teléfono acudiente</label>
                                            <input type="text" class="form-control" name="telefono_acudiente" required placeholder="Ingrese el teléfono">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="last_name">Parentezco</label>
                                            <input type="text" class="form-control" name="" required placeholder="Ingrese el parentezco">
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
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#crear_examenModal" >
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="card-body">
                            <div class="row">
                               <table class="table table-bordered" id="table_examenes_historial">
                                   <thead>
                                       <tr>
                                           <th>#</th>
                                           <th>Id examen</th>
                                           <th>Nombre examen</th>
                                           <th>Descripcion examen</th>
                                       </tr>
                                   </thead>
                                   <tbody>

                                   </tbody>
                               </table>
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
                                        <input type="text" class="form-control" id="id_prescripcion" name="prescripcion_historial_id"  hidden>
                                        <label for="last_name">Anamnesis</label>
                                        <select class="form-control" name="anamnesis">
                                            <option value="" selected disabled> Seleccionar</option>
                                            <option value="1"> Alergias</option>
                                            <option value="2"> Historial Familiar</option>
                                            <option value="3"> Control Medico</option>
                                            <option value="4"> Medicaciones</option>
                                            <option value="5"> Ninguno</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Antedecedentes</label>
                                        <select class="form-control" name="antecedentes">
                                            <option value="" selected disabled> Seleccionar</option>
                                            <option value="1"> Familiares</option>
                                            <option value="2"> Miopia</option>
                                            <option value="3"> Astigmatismo</option>
                                            <option value="4"> Ninguno</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Código RIPS</label>
                                        <input type="text" class="form-control" name="codg_rips" required placeholder="Ingrese el codigo rips">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Conducta</label>
                                        <input type="text" class="form-control" name="conducta" required placeholder="Ingrese la conducta">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="control">Control</label>
                                        <textarea  class="form-control" name="control" required placeholder="Ingrese el control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="diagnostico">Diagnostico</label>
                                        <textarea class="form-control" name="diagnostico" required placeholder="Ingrese el diagnostico"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-default float-right">Cancel</button>
                            <button type="submit" class="btn btn-info">Registrar</button>
                        </div>
                    </div>
                    <!-- /.card -->
                </form>

                <div class="modal fade bd-example-modal-lg" id="crear_examenModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Registrar Examen</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="#">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="last_name">Tipo exámen</label>
                                                <select class="form-control" name="" id="examen_id">
                                                    <option value="" selected disabled> Seleccionar</option>
                                                    <option value="7">Prescripcion final</option>
                                                    <?php
                                                    foreach (ExamenControlador::getAll() as $examen){
                                                        echo '<option value="'. $examen->getIdExamenes().'">'.ucfirst($examen->getNombre()).'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <?php require ('partials/prescripcion_final_form.php');?>
                                    <?php require ('partials/agudeza_visual_form.php');?>
                                    <?php require ('partials/examen_externo_form.php');?>
                                    <?php require ('partials/fondo_de_ojo_form.php');?>
                                    <?php require ('partials/motilidad_ocular_form.php');?>
                                    <?php require ('partials/queratometria_form.php');?>
                                    <?php require ('partials/refraccion_form.php');?>
                                    <?php require ('partials/sujetivo_form.php');?>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" id="save">Registrar</button>
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
            <?php }
            } ?>
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
        var data = []
        var select = "";
        var rows = 0;

        $('#crear_examenModal').on('hidden.bs.modal', function (e) {
            $(this).find('form')[0].reset();
            $('.examenes').hide();
        })

        $( "#save" ).click(function() {
            $(select+" :input").each(function (index,value){
                data.push({
                    name:value.name,
                    value:value.value
                })
            })
            save_examen(data,<?= $_GET["id_cita"] ?>)
             data = []

        });
        
        function save_examen(data, id_cita) {
            let examen_id= $('#examen_id').val()
            const url= select !== "#prescripcion"?
                '../../../App/Controlador/ExamenHistorialControlador.php?action=create':
                '../../../App/Controlador/PrescripcionFinalControlador.php?action=create';

            $.ajax({
                data: {'valores':data,'examen_id':examen_id,'id_cita_examen':id_cita},
                url: url,
                type: 'post',
                beforeSend: function () {
                    console.log("before")
                },
                success: function (response_json) {
                    var response = JSON.parse(response_json)
                    rows ++;
                    var htmlTags = '<tr>'+
                        '<td>' + rows + '</td>'+
                        '<td>' + response["id"] + '</td>'+
                        '<td>' + response["nombre_examen"] + '</td>'+
                        '<td>' + response["descripcion_examen"] + '</td>'+
                        '</tr>';

                    $('#table_examenes_historial').append(htmlTags);
                    $('#crear_examenModal').modal('hide');
                    if(select === "#prescripcion"){
                        $('#id_prescripcion').val(response["id"])
                    }
                    select = ""
                }
            });
        }

        $('#examen_id').on('change', function() {
            $('.examenes').hide();
            console.log(this.value);
            switch (this.value) {
                case "1":
                    $('#agudeza_visual').show();
                    select= "#agudeza_visual";
                    break;
                case "2":
                    $('#examen_externo').show();
                    select= "#examen_externo";
                    break;
                case "3":
                    $('#fondo_de_ojo').show();
                    select= "#fondo_de_ojo";
                    break;
                case "4":
                    $('#motildiad_ocular').show();
                    select= "#motildiad_ocular";
                    break;
                case "5":
                    $('#queratometria').show();
                    select= "#queratometria";
                    break;
                case "6":
                    $('#refraccion').show();
                    select= "#refraccion";
                    break;
                case "7":
                    $('#prescripcion').show();
                    select= "#prescripcion";
                    break;
            }
        });

    });
</script>
</body>
</html>
