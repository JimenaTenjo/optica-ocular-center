
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
        <img src="<?= $baseURL ?>/Vistas/components/img/weber-icon.png"
             alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Optica Ocular Center</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= $baseURL ?>/Vistas/components/img/user.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $_SESSION["user_name"]?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?= $baseURL; ?>/Vistas" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Inicio
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $baseURL; ?>/Vistas/modulos/Persona/index.php" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Persona
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $baseURL; ?>/Vistas/modulos/Cita/index.php" class="nav-link">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>
                            Citas
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $baseURL; ?>/Vistas/modulos/Historial/index.php" class="nav-link">
                        <i class="nav-icon fas fa-notes-medical"></i>
                        <p>
                            Historial
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $baseURL; ?>/Vistas/modulos/MotivoConsulta/index.php" class="nav-link">
                        <i class="nav-icon fas fa-question"></i>
                        <p>
                            Motivo consulta
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $baseURL; ?>/Vistas/modulos/ExamenHistorial/index.php" class="nav-link">
                        <i class="nav-icon fas fa-diagnoses"></i>
                        <p>
                            Historial exmanes
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
