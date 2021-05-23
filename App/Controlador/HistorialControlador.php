<?php
namespace App\Controlador;
require_once (__DIR__ . '/../Modelo/Cita.php');
require_once (__DIR__ . '/../Modelo/Historial.php');
require_once (__DIR__ . '/../../vendor/autoload.php');

use App\Modelo\Cita;
use App\Modelo\Historial;
use Dompdf\Dompdf;
use Exception;


if(!empty($_GET['action'])){
    HistorialControlador::main($_GET['action']);
}

class HistorialControlador
{
    static function main($action)
    {
        if ($action == "create") {
            HistorialControlador::create();
        } else if ($action == "searchForID") {
            HistorialControlador::searchForID($_REQUEST['idHistorial']);
        } else if ($action == "generarPdf") {
            HistorialControlador::generatePdf();
        }
    }

    static public function create()
    {
        try {
            $arrayHistorial = array();
            $arrayHistorial['codg_rips'] = $_POST['codg_rips'];
            $arrayHistorial['conducta'] = $_POST['conducta'];
            $arrayHistorial['control'] = $_POST['control'];
            $arrayHistorial['citas_historial_id'] = $_POST['citas_historial_id'];
            $arrayHistorial['diagnostico'] = $_POST['diagnostico'];
            $arrayHistorial['anamnesis'] = $_POST['anamnesis'];
            $arrayHistorial['antecedentes'] = $_POST['antecedentes'];
            $arrayHistorial['nombre_acuediente'] = $_POST['nombre_acudiente'];
            $arrayHistorial['telefono_acudiente'] = $_POST['telefono_acudiente'];
            $arrayHistorial['prescripcion_historial_id'] = $_POST['prescripcion_historial_id'];

            $historial = new Historial($arrayHistorial);
            $lastId= $historial->create();

            $cita = Cita::searchForId($_POST['citas_historial_id']);
            $cita->setEstado('Inactivo');
            $cita->update();

            header("Location: ../../Vistas/modulos/Historial/show.php?id=".$lastId."&respuesta=correcto&formula=1");
        } catch (Exception $e) {
            header("Location: ../../Vistas/modulos/Cita/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }


    static public function generatePdf(){
        $dompdf = new Dompdf();
        print_r($_GET['id']);
        $dompdf->load_html( file_get_contents(  $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/Vistas/pdf/historial.php?id=".$_GET['id'] ) );
        $dompdf->setPaper('legal', 'portrait');
        $dompdf->render();
        $dompdf->stream("historial.pdf",array('Attachment'=>0));
    }

    static public function searchForID ($id){
        try {
            return Historial::searchForId($id);
        } catch (\Exception $e) {
            var_dump($e);
            return header("Location: ../../views/modules/persona/manager.php?respuesta=error");
        }
    }

    static public function buscarPorDocumentoPaciente($documentoPaciente){
        try {
            return Historial::search("select * from historial 
                INNER JOIN citas ON historial.citas_historial_id = citas.idCita 
                INNER JOIN paciente ON citas.paciente_cita_id = paciente.idPaciente 
                INNER JOIN persona ON paciente.id_persona_paciente = persona.idPersona 
                WHERE persona.numero_documento = '".$documentoPaciente."'");
        } catch (\Exception $e) {
            var_dump($e);
            return header("Location: ../../vistas/modulos/Historial/index.php?respuesta=error");
        }
    }
}