<?php
namespace App\Controlador;
require_once(__DIR__ . '/../Modelo/Paciente.php');
require_once(__DIR__ . '/../Modelo/Persona.php');
use App\Modelo\Paciente;
use App\Modelo\Persona;

if(!empty($_GET['action'])){
    PacienteControlador::main($_GET['action']);
}

class PacienteControlador
{
    static function main($action)
    {
        if ($action == "searchPatientForDocument") {
            PacienteControlador::buscarPacientePorDocumento();
        }
    }

    static public function buscarPacientePorDocumento(){
        $objPaciente =Paciente::search("SELECT * FROM optica.paciente INNER JOIN optica.persona ON optica.paciente.id_persona_paciente = optica.persona.IdPersona
            where optica.persona.numero_documento = '".$_POST['documento_paciente']."'");

        if(count($objPaciente)>0){
            echo json_encode([
                "id" => $objPaciente[0]->getIdPaciente(),
                "nombre" => $objPaciente[0]->getIdPersonaPaciente()->getFullName()
            ]);
        }else{
            echo "";
        }
    }

    static public function getAll (){
        try {
            return Paciente::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            return header("Location: ../Vista/modulos/Dashboard/index.php?respuesta=error al obtener el total de pacientes");
        }
    }
}