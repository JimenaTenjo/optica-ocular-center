<?php

namespace App\Controlador;
require_once (__DIR__ . '/../Modelo/Cita.php');
use App\Modelo\Cita;
use Exception;

if(!empty($_GET['action'])){
    CitaControlador::main($_GET['action']);
}

class CitaControlador
{
    static function main($action)
    {
        if ($action == "searchForID") {
            CitaControlador::searchForID($_REQUEST['idPersona']);
        } else if ($action == "searchAll") {
            CitaControlador::getAll();
        }else if ($action == "searchAvailableHours") {
            CitaControlador::buscarHorarioDisponible();
        }else if ($action == "create") {
            CitaControlador::create();
        }else if ($action == "activate") {
            CitaControlador::activate();
        }else if ($action == "inactivate") {
            CitaControlador::inactivate();
        }
        else if ($action == "inactivateFromDashboard") {
            CitaControlador::inactivateFromDashboard();
        }
    }

    static public function create(){
        try {
            $arrayCita = array();
            $arrayCita['fecha'] = $_POST['fecha'];
            $arrayCita['hora'] = $_POST['hora'];
            $arrayCita['estado'] = "Activo";
            $arrayCita['motivo_consulta_id'] = $_POST['id_motivo_cita'];
            $arrayCita['paciente_cita_id'] = $_POST['id_paciente_cita'];
            $arrayCita['medico_cita_id'] = $_POST['id_medico_cita'];

            $cita = new Cita($arrayCita);
            var_dump($cita->create());
            header("Location: ../../Vistas/modulos/Cita/index.php?respuesta=correcto");
        }catch (Exception $e){
            header("Location: ../../Vistas/modulos/cita/index.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }


    static public function activate (){
        try {
            $objCita = Cita::searchForId($_GET['Id']);
            $objCita->setEstado("Activo");

            if($objCita->update()){
                header("Location: ../../Vistas/modulos/Cita/index.php");
            }else{
                header("Location: ../../Vistas/modulos/Cita/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../Vistas/modulos/cita/index.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function inactivate (){
        try {

            $objCita = Cita::searchForId($_GET['Id']);
            $objCita->setEstado("Inactivo");

            if($objCita->update()){
                header("Location: ../../Vistas/modulos/Cita/index.php");
            }else{
                header("Location: ../../Vistas/modulos/Cita/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            var_dump($e);
            header("Location: ../../Vistas/modulos/Cita/index.php?respuesta=error");
        }
    }

    static public function inactivateFromDashboard(){
        try {
            $objCita = Cita::searchForId($_GET['IdCita']);
            $objCita->setEstado("Inactivo");

            if($objCita->update()){
                header("Location: ../../Vistas/modulos/Dashboard/index.php");
            }else{
                header("Location: ../../Vistas/modulos/Dashboard/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../../Vistas/modulos/Dashboard/index.php?respuesta=error");
        }
    }

    static public function searchForID ($id){
        try {
            return Cita::searchForId($id);
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../../views/modules/persona/manager.php?respuesta=error");
        }
    }


    static public function getAll (){
        try {
            return Cita::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }

    // obtiene y almacena la hora de los registros con la fecha actual
    static public function buscarHorarioDisponible(){
        $date = date("Y-m-d H:i:s",strtotime( $_POST['fecha_cita']));
        $arrayHora=  Array();
        $arrayCitas =Cita::search("SELECT * FROM optica.citas where fecha ='".$date."'");
        foreach ($arrayCitas as $cita){
            $arrayHora[]=$cita->getHora();
        }
        echo json_encode($arrayHora);
    }

    // obtiene todas las citas del día actual
    static public function filterToDay(){
        try {
            date_default_timezone_set('America/Bogota');
            $date = date("Y-m-d");
            $arrayCitas = Cita::search("SELECT * FROM optica.citas where fecha ='".$date."' AND estado ='Activo' ORDER BY hora");
            return $arrayCitas;

        }catch (Exception $e){
            var_dump($e);
        }
    }

}