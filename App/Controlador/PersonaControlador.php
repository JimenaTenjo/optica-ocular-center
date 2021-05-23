<?php
namespace App\Controlador;
require_once(__DIR__ . '/../Modelo/Persona.php');
require_once(__DIR__ . '/../Modelo/Paciente.php');
require_once(__DIR__ . '/../Modelo/Medico.php');

if(!isset($_SESSION))
{
    session_start();
}

use App\Modelo\Medico;
use App\Modelo\Paciente;
use App\Modelo\Persona;
use Exception;

if(!empty($_GET['action'])){
    PersonaControlador::main($_GET['action']);
}


class PersonaControlador
{
    static function main($action)
    {
        if ($action == "create") {
            PersonaControlador::create();
        } else if ($action == "edit") {
            PersonaControlador::edit();
        } else if ($action == "searchForID") {
            PersonaControlador::searchForID($_REQUEST['idPersona']);
        } else if ($action == "searchAll") {
            PersonaControlador::getAll();
        } else if ($action == "activate") {
            PersonaControlador::activate();
        } else if ($action == "inactivate") {
            PersonaControlador::inactivate();
        }else if ($action == "login"){
            PersonaControlador::login();
        }else if($action == "cerrarSession"){
            PersonaControlador::logout();
        }else if($action == "cambiarContrasena"){
            PersonaControlador::updatePassword();
        }
    }

    static public function create()
    {
        try {
            $arrayPersona = array();
            $arrayPersona['nombres'] = $_POST['nombres'];
            $arrayPersona['apellidos'] = $_POST['apellidos'];
            $arrayPersona['numero_documento'] = $_POST['numero_documento'];
            $arrayPersona['tipo_documento'] = $_POST['tipo_documento'];
            $arrayPersona['ciudad'] = $_POST['ciudad'];
            $arrayPersona['genero'] = $_POST['genero'];
            $arrayPersona['email'] = $_POST['email'];
            $arrayPersona['telefono'] = $_POST['telefono'];
            $arrayPersona['estado'] = 'Activo';
            $arrayPersona['rol'] = $_POST['rol'];
            $arrayPersona['direccion'] = $_POST['direccion'];
            $arrayPersona['fecha_nacimiento'] = date("Y-m-d H:i:s",strtotime( $_POST['fecha_nacimiento']));
            if( $arrayPersona['rol']!="PACIENTE"){
                $arrayPersona['contrasena'] = $_POST['contrasena'];
            }

            if(!Persona::personaregistrada($arrayPersona['numero_documento'])){
                $persona = new Persona ($arrayPersona);
                $lastId = $persona->create();
                if($arrayPersona['rol'] == "PACIENTE"){
                    PersonaControlador::createPatient($lastId);
                }elseif ($arrayPersona['rol'] == "MEDICO"){
                    PersonaControlador::createDoctor($lastId);
                }
                header("Location: ../../Vistas/modulos/Persona/index.php?respuesta=correcto");
            }else{
                header("Location: ../../Vistas/modulos/Persona/create.php?respuesta=error&mensaje=Usuario ya registrado");
            }
        } catch (Exception $e) {
            header("Location: ../../Vistas/modulos/Persona/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function createPatient($id_persona_paciente){
        $arrayPaciente = array();
        $arrayPaciente['ocupacion'] = $_POST['ocupacion'];
        $arrayPaciente['estado_civil'] = $_POST['estado_civil'];
        $arrayPaciente['tipo_afiliacion'] = $_POST['tipo_afiliacion'];
        $arrayPaciente['tipo_vinculacion'] = $_POST['tipo_vinculacion'];
        $arrayPaciente['id_persona_paciente'] = $id_persona_paciente;
        
        $paciente = new Paciente($arrayPaciente);
        $paciente->create();
    }

    static public function createDoctor($id_persona_medico){
        $arrayMedico = array();
        $arrayMedico['especializacion'] = $_POST['especializacion'];
        $arrayMedico['licencia'] = $_POST['licencia'];
        $arrayMedico['persona_medico'] = $id_persona_medico;

        $medico = new Medico($arrayMedico);
        $medico->create();
    }

    static public function edit (){
        try {
            $objPersona = Persona::searchForId($_POST['idPersona']);

            $arrayPersona = array();
            $arrayPersona['nombres'] = $_POST['nombres'];
            $arrayPersona['apellidos'] = $_POST['apellidos'];
            $arrayPersona['numero_documento'] = $_POST['numero_documento'];
            $arrayPersona['tipo_documento'] = $_POST['tipo_documento'];
            $arrayPersona['ciudad'] = $_POST['ciudad'];
            $arrayPersona['genero'] = $_POST['genero'];
            $arrayPersona['email'] = $_POST['email'];
            $arrayPersona['telefono'] = $_POST['telefono'];
            $arrayPersona['estado'] = $objPersona->getEstado();
            $arrayPersona['rol'] = $_POST['rol'];
            $arrayPersona['direccion'] = $_POST['direccion'];
            $arrayPersona['fecha_nacimiento'] = date("Y-m-d H:i:s",strtotime( $_POST['fecha_nacimiento']));
            if( $arrayPersona['rol']!="PACIENTE"){
                $arrayPersona['contrasena'] = $objPersona->getContrasena();
            }
            $arrayPersona['idPersona'] = $_POST['idPersona'];


            $persona = new Persona($arrayPersona);
            var_dump($persona->update());

            header("Location: ../../Vistas/modulos/persona/show.php?id=".$persona->getIdPersona()."&respuesta=correcto");
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../Vistas/modulos/persona/edit.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function updatePassword(){
        try {
            $objPersona = Persona::searchForId($_POST['idPersona']);
            $objPersona->setContrasena($_POST["contrasena"]);
            var_dump($objPersona->update());

            header("Location: ../../Vistas/modulos/persona/index.php?&respuesta=correcto_password&");
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../Vistas/modulos/persona/edit.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function activate (){
        try {
            $objPersona = Persona::searchForId($_GET['Id']);
            $objPersona->setEstado("Activo");

            if($objPersona->update()){
                header("Location: ../../Vistas/modulos/Persona/index.php");
            }else{
                header("Location: ../../Vistas/modulos/Persona/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../Vistas/modulos/Persona/index.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function inactivate (){
        try {

            $objPersona = Persona::searchForId($_GET['Id']);
            $objPersona->setEstado("Inactivo");

            if($objPersona->update()){
                header("Location: ../../Vistas/modulos/Persona/index.php");
            }else{
                header("Location: ../../Vistas/modulos/Persona/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            var_dump($e);
            header("Location: ../../Vistas/modulos/Persona/index.php?respuesta=error");
        }
    }

    static public function searchForID ($id){
        try {
            return Persona::searchForId($id);
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../../views/modules/persona/manager.php?respuesta=error");
        }
    }


    static public function getAll (){
        try {
            return Persona::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }

    static public function login(){
        if (isset($_POST['iniciar'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            $result = Persona::search('SELECT * FROM optica.persona WHERE  email = "'. $email .' "');
            var_dump($result);

            if (!$result) {
                header("Location: ../../Vistas/modulos/Persona/login.php?respuesta=error_usuario");
            } else {
                if (password_verify($password, $result[0]->getContrasena())) {
                   if($result[0]->getEstado()== "Activo"){
                       $_SESSION['user_id'] = $result[0]->getIdPersona();
                       $_SESSION['user_name'] = $result[0]->getNombres();
                       header("Location: ../../Vistas/modulos/Dashboard/index.php");
                   }else{
                       header("Location: ../../Vistas/modulos/Persona/login.php?respuesta=error_estado");
                   }
                } else {
                    header("Location: ../../Vistas/modulos/Persona/login.php?respuesta=error_usuario");
                }
            }
        }


    }

    static function logout(){
        if ($_SESSION["user_id"]) {
            unset($_SESSION["user_id"]);
            unset($_SESSION["user_name"]);
            header("Location: ../../Vistas/modulos/Persona/login.php?respuesta=logout");
        }
    }

}