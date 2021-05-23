<?php


namespace App\Controlador;
require_once (__DIR__ . '/../Modelo/Medico.php');

use App\Modelo\Medico;


class MedicoControlador
{
    static public function getAll (){
        try {
            return Medico::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            return header("Location: ../Vista/modulos/Dashboard/index.php?respuesta=error al obtener el total de médicos");
        }
    }
}