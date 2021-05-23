<?php

namespace App\Controlador;
require_once(__DIR__ . '/../Modelo/PrescripcionFinal.php');

use App\Modelo\PrescripcionFinal;

if(!empty($_GET['action'])){
    PrescripcionFinalControlador::main($_GET['action']);
}

class PrescripcionFinalControlador
{
    static function main($action)
    {
        if ($action == "create") {
            PrescripcionFinalControlador::create();
        }
    }

    static public function create()
    {
        try {
            $values= $_POST['valores'];
            $arrayPrescripcionFinal = array();
            $arrayPrescripcionFinal['OI'] = $values[0]['value'];
            $arrayPrescripcionFinal['OD'] = $values[1]['value'];
            $arrayPrescripcionFinal['ADD_OD'] = $values[2]['value'];
            $arrayPrescripcionFinal['ADD_OI'] = $values[4]['value'];
            $arrayPrescripcionFinal['AV_VL_OD'] = $values[3]['value'];
            $arrayPrescripcionFinal['AV_VL_OI'] = $values[5]['value'];
            $arrayPrescripcionFinal['AV_VP_OD'] = $values[6]['value'];
            $arrayPrescripcionFinal['AV_VP_OI'] = $values[7]['value'];
            $arrayPrescripcionFinal['DNP_OD'] = $values[8]['value'];
            $arrayPrescripcionFinal['DNP_OI'] = $values[9]['value'];

            $prescripcionFinal = new PrescripcionFinal($arrayPrescripcionFinal);
            $last_id= $prescripcionFinal->create();

            echo json_encode([
                "id" => $last_id,
                "nombre_examen" => 'Prescripcion final',
                "descripcion_examen"=> 'Prescripcion final',
            ]);

        } catch (Exception $e) {
            echo json_encode([
                "error" => $e
            ]);
        }
    }
}