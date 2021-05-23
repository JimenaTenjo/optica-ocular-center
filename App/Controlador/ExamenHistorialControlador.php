<?php
namespace App\Controlador;
require_once(__DIR__ . '/../Modelo/ExamenHistorial.php');
require_once(__DIR__ . '/../Modelo/Examen.php');
require_once(__DIR__ . '/../Modelo/Cita.php');

use App\Modelo\Examen;
use App\Modelo\ExamenHistorial;

if(!empty($_GET['action'])){
    ExamenHistorialControlador::main($_GET['action']);
}

class ExamenHistorialControlador
{
    static function main($action)
    {
        if ($action == "create") {
            ExamenHistorialControlador::create();
        } else if ($action == "edit") {
            ExamenHistorialControlador::edit();
        } else if ($action == "searchForID") {
            ExamenHistorialControlador::searchForID($_REQUEST['idPersona']);
        } else if ($action == "searchAll") {
            ExamenHistorialControlador::getAll();
        } else if ($action == "exmanesHistorialJson") {
            ExamenHistorialControlador::jsonFilterByCitaId();
        }else if ($action == "eliminar") {
            ExamenHistorialControlador::destroy();
        }


    }

    static public function create (){
        try {
            $arrayExamenHistorial = array();
            $arrayExamenHistorial['examen_id'] = $_POST['examen_id'];
            $arrayExamenHistorial['id_cita_examen'] = $_POST['id_cita_examen'];
            $arrayExamenHistorial['valores'] = $_POST['valores'];

            $examenHistorial = new ExamenHistorial($arrayExamenHistorial);
            $last_id= $examenHistorial->create();

            echo json_encode([
                "id" => $last_id,
                "nombre_examen" => $examenHistorial->getExamenId()->getNombre(),
                "descripcion_examen"=> $examenHistorial->getExamenId()->getDescripcion(),
            ]);

        } catch (Exception $e) {
            echo json_encode([
                "error" => $e
            ]);
        }
    }

    static public function edit (){
        try {

            $arrayExamenHistorial = array();
            $arrayExamenHistorial['examen_id'] = $_POST['examen_id'];
            $arrayExamenHistorial['valores'] = $_POST['valores'];
            $arrayExamenHistorial['IdExamenHistorial'] = $_POST['id_examen_historial'];

            $examenHistorial = new ExamenHistorial($arrayExamenHistorial);
            $examenHistorial->update();
            echo json_encode([
                "mensaje" => "ok"
            ]);

        } catch (\Exception $e) {
            //var_dump($e);
            echo json_encode([
                "mensaje" => $e
            ]);
        }
    }

    static public function getAll (){
        try {
            return ExamenHistorial::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            return header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }


    static public function searchForID ($id){
        try {
            return ExamenHistorial::searchForId($id);
        } catch (\Exception $e) {
            var_dump($e);
            return header("Location: ../../vistas/modulos/ExamenHistorial/index.php?respuesta=error");
        }
    }

    static public function filterByCitaId($citaId){
        try {
            return ExamenHistorial::search('select * from examenes_historial where id_cita_examen = '.$citaId);
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }

    static public function jsonFilterByCitaId(){
        try{
            $examenes_historial= [];
            $examenes = ExamenHistorial::search('select * from examenes_historial where id_cita_examen = '.$_POST["cita_id"]);
            foreach ($examenes as $examen){
                array_push($examenes_historial,[
                    "id_examen_historial" => $examen->getIdExamenHistorial(),
                    "nombre_examen" => $examen->getExamenId()->getNombre(),
                    "descripcion_examen" => $examen->getExamenId()->getDescripcion()
                ]);
            }

            echo json_encode([
                "mensaje" => "ok",
                "data" => $examenes_historial
            ]);

        } catch (\Exception $e) {
            //var_dump($e);
            echo json_encode([
                "mensaje" => $e
            ]);
        }
    }

    static public function getCitas($citaId){
        $examenes = array();
        foreach (Examen::getAll() as $examen){
            $result = ExamenHistorial::search('select * from examenes_historial where id_cita_examen = '.$citaId.' AND examen_id ='.$examen->getIdExamenes());
            if(count($result)>0){
                $examenes[$examen->getNombre()]= $result[0];
            }else{
                $examenes[$examen->getNombre()]= $result;
            }

        }
        return $examenes;
    }

    static public function destroy(){
        $examenHistorialId = $_POST["examen_historial_id"];
        try{
            $examenHistorial = new ExamenHistorial();
            $examenHistorial->deleted($examenHistorialId);
            echo json_encode([
                "mensaje" => "ok"
            ]);
        }catch (\Exception $e){
            echo json_encode([
                "error" => $e
            ]);
        }
    }
}