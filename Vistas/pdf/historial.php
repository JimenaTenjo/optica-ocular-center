<?php
require("../../App/Controlador/HistorialControlador.php");
require("../../App/Controlador/ExamenHistorialControlador.php");

use App\Controlador\ExamenHistorialControlador;
use App\Controlador\HistorialControlador;

 if(!empty($_GET["id"]) && isset($_GET["id"])){
     $historial= HistorialControlador::searchForID($_GET["id"]);
     $cita= $historial->getCitasHistorialId();
     $paciente= $cita->getPacienteCitaId();
     $examenes= ExamenHistorialControlador::getCitas($cita->getIdCita());
     $agudeza_visual = json_decode(($examenes['agudeza visual']->getValores()));
 }else{
     $historial = '';
 }
?>

<style>
    table td{
        font-size: 12px;
        letter-spacing: 0;
    }
    table td span{
        text-decoration-line: underline;
    }
</style>
<!-- INFORMACIÓN GENERAL -->
<table style="width: 100%">
    <tr style="text-align: center">
        <td style="font-weight: bold" colspan="4"><strong>OCULAR</strong></td>
    </tr>
    <tr style="text-align: center">
        <td colspan="4"><strong>HISTORIA CLÍNICA DE OPTOMETRÍA</strong></td>
    </tr>
    <tr style="text-align: right">
        <td colspan="4">
            <strong>FECHA:</strong>
            <span><?= $cita->getFecha().' '.$cita->getHora()?></span>
        </td>
    </tr>
    <tr>
        <td colspan="2"><strong>APELLIDOS Y NOMBRES DEL PACIENTE:</strong> <?= $paciente->getIdPersonaPaciente()->getFullName()?></td>
        <td style="text-align: right" colspan="2"><strong>DOCUMENTO IDENTIDAD:</strong> <?= $paciente->getIdPersonaPaciente()->getFullName()?></td>
    </tr>
    <tr>
        <td><strong>EDAD:</strong> <?= $paciente->getIdPersonaPaciente()->getEdad()?></td>
        <td><strong>FECHA DE NACIMIENTO:</strong> <?= $paciente->getIdPersonaPaciente()->getFechaNacimiento()?></td>
        <td><strong>SEXO:</strong> <?= $paciente->getIdPersonaPaciente()->getGenero()?></td>
        <td><strong>OCUPACIÓN:</strong> <?= $paciente->getOcupacion()?></td>
    </tr>
    <tr>
        <td colspan="2"><strong>DIRECCIÓN DE DOMICILIO:</strong> <?= $paciente->getIdPersonaPaciente()->getDireccion()?></td>
        <td><strong>ESTADO CIVIL:</strong> <?= $paciente->getEstadoCivil()?></td>
        <td><strong>TELÉFONO:</strong> <?= $paciente->getIdPersonaPaciente()->getTelefono()?></td>
    </tr>
    <tr>
        <td><strong>ASEGURADORA:</strong> <?= $paciente->getTipoAfiliacion()?></td>
        <td><strong>TIPO DE VINCULACIÓN:</strong> <?= $paciente->getTipoVinculacion()?></td>
    </tr>
    <tr>
        <td colspan="2"><strong>CORREO ELECTRÓNICO:</strong> <?= $paciente->getIdPersonaPaciente()->getEmail()?></td>
        <td><strong>FECHA ULTIMO CONTROL:</strong> <?= $paciente->getFechaUltimaCita()?></td>
        <td><strong>CELULAR:</strong> <?= $paciente->getIdPersonaPaciente()->getTelefono()?></td>
    </tr>
    <tr>
        <td colspan="2"><strong>NOMBRE DEL ACOMPAÑANTE DEL PACIENTE:</strong> <?= $historial->getNombreAcudiente()?></td>
        <td><strong>PARENTESCO:</strong> </td>
        <td><strong>TELÉFONO:</strong> <?= $historial->getTelefonoAcudiente()?></td>
    </tr>
    <tr>
        <td colspan="3"><strong>NOMBRE DEL CUDIENTE DEL PACIENTE:</strong> <?= $historial->getNombreAcudiente()?></td>
        <td><strong>TELÉFONO:</strong>  <?= $historial->getTelefonoAcudiente()?></td>
    </tr>
</table>

<!-- INFORMACIÓN EXÁMENES -->
<table style="width: 100%">
    <tr>
        <td><strong>MOTIVO CONSULTA:</strong> <?= $historial->getNombreAcudiente()?></td>
    </tr>
    <tr>
        <td><strong>ANAMNESIS:</strong> <?= $historial->getNombreAcudiente()?></td>
    </tr>
    <tr>
        <td><strong>ANTECEDENTES:</strong> <?= $historial->getNombreAcudiente()?></td>
    </tr>
    <tr>
        <td><strong>AGUDEZA VISUAL:</strong>
            <table style="width: 100%">

                <?php
                if ($examenes['agudeza visual']!= null){
                    $agudeza_visual = json_decode(($examenes['agudeza visual']->getValores()));
                    echo "<tr><td><strong>SC VL OD:</strong> ".$agudeza_visual[0]->value."</td>
                           <td><strong>SC VL OI:</strong> ".$agudeza_visual[1]->value."</td></tr>
                           <tr><td><strong>OBSERVACIONES:</strong> ".$agudeza_visual[2]->value."</td></tr>
                          ";
                }else{
                    echo "<tr><td><strong>SC VL OD:</strong></td>
                           <td><strong>SC VL OI:</strong></td></tr>
                           <tr><td><strong>OBSERVACIONES:</strong></td></tr>
                          ";
                }
                ?>
                <?php
                if ($examenes['agudeza visual']!= null){
                    $agudeza_visual = json_decode(($examenes['agudeza visual']->getValores()));
                    echo "<tr>
                            <td><strong>EXAMEN EXTERNO</strong><br><strong>OD:</strong> ".$agudeza_visual[0]->value."</td>
                           <td><strong>OI:</strong> ".$agudeza_visual[1]->value."</td></tr>
                        <td><strong>FONDO DE OJO</strong><br><strong>OD:</strong> ".$agudeza_visual[0]->value."</td>
                           <td><strong>OI:</strong> ".$agudeza_visual[1]->value."</td></tr>
                          ";
                }else{
                    echo "<tr><td><strong>SC VL OD:</strong></td>
                           <td><strong>SC VL OI:</strong></td></tr>
               
                          ";
                }
                ?>

            </table>
        </td>
    </tr>

</table>