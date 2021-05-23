<?php


namespace App\Controlador;
require_once (__DIR__ . '/../Modelo/MotivoConsulta.php');

use App\Modelo\MotivoConsulta;


if(!empty($_GET['action'])){
    MotivoConsultaControlador::main($_GET['action']);
}

class MotivoConsultaControlador
{

    static function main($action)
    {
        if ($action == "create") {
            MotivoConsultaControlador::create();
        } else if ($action == "edit") {
            MotivoConsultaControlador::edit();
        } else if ($action == "searchAll") {
            MotivoConsultaControlador::getAll();
        }
    }

    static public function create(){
        try {
            $arrayMotivoConsulta = array();
            $arrayMotivoConsulta['descripcion'] = $_POST['descripcion'];
            $arrayMotivoConsulta['estado'] = $_POST['estado'];

            $motivoConsulta = new MotivoConsulta($arrayMotivoConsulta);

            var_dump($motivoConsulta->create());
            header("Location: ../../Vistas/modulos/MotivoConsulta/index.php?respuesta=correcto");
        } catch (Exception $e) {
            var_dump($e);
            header("Location: ../../Vistas/modulos/MotivoConsulta/index.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit (){
        try {

            $arrayMotivoConsulta = array();
            $arrayMotivoConsulta['descripcion'] = $_POST['descripcion'];
            $arrayMotivoConsulta['estado'] = $_POST['estado'];
            $arrayMotivoConsulta['idMotivoConsulta'] = $_POST['idMotivoConsulta'];

            $motivoConsulta = new MotivoConsulta($arrayMotivoConsulta);
            var_dump($motivoConsulta->update());

            header("Location: ../../Vistas/modulos/MotivoConsulta/index.php?respuesta=correcto");
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../Vistas/modulos/MotivoConsulta/index.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function getAll (){
        try {
            return MotivoConsulta::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            return header("Location: ../Vista/modulos/Dashboard/index.php?respuesta=error al obtener el total de médicos");
        }
    }
}