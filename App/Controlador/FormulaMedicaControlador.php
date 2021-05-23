<?php

namespace App\Controlador;

require_once (__DIR__ . '/../Modelo/FormulaMedica.php');
use App\Modelo\FormulaMedica;

if(!empty($_GET['action'])){
    FormulaMedicaControlador::main($_GET['action']);
}

class FormulaMedicaControlador
{
    static function main($action)
    {
        if ($action == "create") {
            FormulaMedicaControlador::create();
        }


    }

    static public function create(){
        try{
            if($_POST["id_prescripcion_formula"]!=null){

                $arrayFormulaMedica = array();
                $arrayFormulaMedica['fecha'] = date("Y-m-d H:i:s");
                $arrayFormulaMedica['descripcion'] = $_POST['descripcion'];
                $arrayFormulaMedica['id_prescripcion_formula'] = $_POST['id_prescripcion_formula'];

                $formulaMedica = new FormulaMedica($arrayFormulaMedica);
                $last_id= $formulaMedica->create();

                echo json_encode([
                    "mensaje" => "Fórmula médica creada con éxito",
                    "id" => $last_id
                ]);
            }else{
                echo json_encode([
                    "mensaje" => "No se puede crear la fórmula médica sin una prescripción final"
                ]);
            }

        }catch (\Exception $e){
            echo json_encode([
                "mensaje" => "Error al crear la fórmula médica, vuelva a intentarlo"
            ]);
        }
    }

    static public function searchForID ($id){
        try {
            return FormulaMedica::searchForId($id);
        } catch (\Exception $e) {
            var_dump($e);
            return header("Location: ../../Vistas/modulos/FormulaMedica/index.php?respuesta=error");
        }
    }

}