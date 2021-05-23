<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: ../Persona/login.php');
    exit;
}
require("../../partials/routes.php");
require("../../../App/Controlador/PersonaControlador.php");
use App\Controlador\personacontrolador;

  if(!empty($_GET['respuesta']) && isset($_GET['respuesta'])){
      $respuesta = $_GET['respuesta'];
  }else{
      $respuesta = "";
  }
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= getenv('TITLE_SITE') ?> | Layout</title>
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
                        <h1>Pagina Principal</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/Vistas/">optica-ocular-center</a></li>
                            <li class="breadcrumb-item active">Inicio</li>
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
                            El usuario ha sido creado con exito!
                        <?php }else if($_GET['action'] == "update"){ ?>
                            Los datos de la persona han sido actualizados correctamente!
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php } ?>

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gestionar Persona</h3>
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
                            <a role="button" href="create.php" class="btn btn-primary float-right" style="margin-right: 5px;">
                                <i class="fas fa-plus"></i> Crear Persona
                            </a>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px">
                        <div class="col">
                            <table id="tblPersona" class="datatable table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tipo documento</th>
                                    <th>Número documento</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $arrpersona = personacontrolador::getAll();
                                foreach ($arrpersona as $persona){
                                    ?>
                                    <tr>
                                        <td><?php echo $persona->getIdPersona(); ?></td>
                                        <td><?php echo $persona->getTipoDocumento(); ?></td>
                                        <td><?php echo $persona->getNumeroDocumento(); ?></td>
                                        <td><?php echo $persona->getNombres(); ?></td>
                                        <td><?php echo $persona->getApellidos(); ?></td>
                                        <td><?php echo $persona->getEmail(); ?></td>
                                        <td><?php echo $persona->getEstado(); ?></td>
                                        <td><?php echo $persona->getRol(); ?></td>
                                        <td>
                                            <a href="edit.php?id=<?php echo $persona->getIdPersona(); ?>" type="button" data-toggle="tooltip" title="Actualizar" class="btn docs-tooltip btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                                            <a href="show.php?id=<?php echo $persona->getIdPersona(); ?>" type="button" data-toggle="tooltip" title="Ver" class="btn docs-tooltip btn-warning btn-xs"><i class="fa fa-eye"></i></a>
                                            <?php if ($persona->getEstado() != "Activo"){ ?>
                                                <a href="../../../App/Controlador/PersonaControlador.php?action=activate&Id=<?php echo $persona->getIdPersona(); ?>"  data-toggle="tooltip" title="Activar" class="btn docs-tooltip btn-success btn-xs"><i class="fa fa-check-square"></i></a>
                                            <?php }else{ ?>
                                                <a href="../../../App/Controlador/PersonaControlador.php?action=inactivate&Id=<?php echo $persona->getIdPersona(); ?>" data-toggle="tooltip" title="Inactivar" class="btn docs-tooltip btn-danger btn-xs"><i class="fa fa-times-circle"></i></a>
                                            <?php } ?>
                                            <button  type="button" data-toggle="modal" data-target="#cambiar_contrasena_<?= $persona->getIdPersona()?>" title="Cambiar contraseña"
                                                     class="btn docs-tooltip btn-info btn-xs"><i class="fa fa-key"></i></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Tipo documento</th>
                                    <th>Número documento</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    Pie de Página.
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php
        foreach ($arrpersona as $persona){
            if($persona->getRol()!= "PACIENTE"){
                ?>
                <div class="modal fade" id="cambiar_contrasena_<?= $persona->getIdPersona() ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="../../../App/Controlador/PersonaControlador.php?action=cambiarContrasena" method="post">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Cambiar contraseña: <?= ucwords($persona->getFullName()) ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Nueva contraseña</label>
                                                    <input type="password" class="form-control" name="contrasena" placeholder="Ingrese la contraseña" required>
                                                    <input type="password" class="form-control" name="idPersona" hidden required value="<?=  $persona->getIdPersona() ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Repetir contraseña</label>
                                                    <input type="password" class="form-control" name="r_contrasena" placeholder="Ingrese la contraseña" required>
                                                </div>
                                            </div>
                                        </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
    <?php
            }
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
    $(document).ready(function() {
        if("<?= $respuesta ?>" !== "" ){
            if("<?= $respuesta ?>" === "correcto"){
                Swal.fire({
                    position: 'top-end',
                    width:300,
                    icon: 'success',
                    text: 'Persona registrada correctamente',
                    showConfirmButton: false,
                    timer: 2000
                })
            }else if("<?= $respuesta ?>" === "correcto_password"){
                Swal.fire({
                    position: 'top-end',
                    width:300,
                    icon: 'success',
                    text: 'Contraseña actualizada correctamente',
                    showConfirmButton: false,
                    timer: 2000
                })
            }else{
                Swal.fire({
                    position: 'top-end',
                    width:300,
                    icon: 'error',
                    text: 'Error al crear el registro',
                    showConfirmButton: false,
                    timer: 2000
                })
            }

        }

        $("#tblPersona").DataTable({
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
