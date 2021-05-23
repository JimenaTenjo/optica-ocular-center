<?php
namespace App\Controlador;

require_once (__DIR__ . '/../Modelo/Examen.php');
use App\Modelo\Examen;
use Exception;

if(!empty($_GET['action'])){
    ExamenControlador::main($_GET['action']);
}


class ExamenControlador
{
    static function main($action)
    {
        if ($action == "create") {
            ExamenControlador::create();
        } else if ($action == "edit") {
            ExamenControlador::edit();
        } else if ($action == "searchForID") {
            ExamenControlador::searchForID($_REQUEST['idPersona']);
        } else if ($action == "searchAll") {
            ExamenControlador::getAll();
        }
    }

    static public function create(){

        try {
            $arrayExamen = array();
            $arrayExamen['nombre'] = $_POST['nombre'];
            $arrayExamen['descripcion'] = $_POST['descripcion'];

            $examen = new Examen($arrayExamen);

            var_dump($examen->create());
            header("Location: ../../Vistas/modulos/Examen/index.php?respuesta=correcto");
        } catch (Exception $e) {
            var_dump($e);
            header("Location: ../../Vistas/modulos/Examen/index.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit (){
        try {

            $arrayExamen = array();
            $arrayExamen['nombre'] = $_POST['nombre'];
            $arrayExamen['descripcion'] = $_POST['descripcion'];
            $arrayExamen['idExamenes'] = $_POST['idExamenes'];

            $examen = new Examen($arrayExamen);
            var_dump($examen->update());

            header("Location: ../../Vistas/modulos/Examen/index.php?id=".$examen->getIdExamenes()."&respuesta=correcto");
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../Vistas/modulos/Examen/index.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function getAll (){
        try {
            return Examen::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }
}