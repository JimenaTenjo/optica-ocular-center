<?php

namespace App\Modelo;
require_once ('db_abstract_class.php');

class Examen extends db_abstract_class
{
    private $idExamenes;
    private $nombre;
    private $descripcion;

    /**
     * persona constructor.
     * @param $idExamenes
     * @param $nombre
     * @param $descripcion
     */
    public function __construct($Examen=array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->idExamenes = $Examen ['idExamenes'] ?? null;
        $this->nombre = $Examen ['nombre'] ?? null;
        $this->descripcion = $Examen ['descripcion'] ?? null;

    }

    /**
     * @return null
     */
    public function getIdExamenes()
    {
        return $this->idExamenes;
    }

    /**
     * @param null $idExamenes
     */
    public function setIdExamenes( $idExamenes): void
    {
        $this->idExamenes = $idExamenes;
    }

    /**
     * @return null
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param null $nombre
     */
    public function setNombre( $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return null
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param null $descripcion
     */
    public function setDescripcion( $descripcion): void
    {
        $this->descripcion = $descripcion;
    }



    public static function search($query)
    {
        $ArrExamen = array();
        $tmp = new Examen();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $examen = new Examen();
            $examen->idExamenes = $valor['idExamenes'];
            $examen->nombre = $valor['nombre'];
            $examen->descripcion = $valor['descripcion'];
            $examen->Disconnect();
            array_push($ArrExamen, $examen);
        }
        $tmp->Disconnect();
        return $ArrExamen;
    }

    public static function getAll()
    {
        return Examen::search("SELECT * FROM optica.examenes");
    }

    public static function searchForId($idExamen)
    {
        $examen = new Examen();
        if ($idExamen > 0){
            $getrow = $examen->getRow("SELECT * FROM optica.examenes WHERE idExamenes =?", array($idExamen));
            $examen->idExamenes = $getrow['idExamenes'];
            $examen->nombre = $getrow['nombre'];
            $examen->descripcion = $getrow['descripcion'];
            $examen->Disconnect();
            return $examen;
        }else{
            $examen->Disconnect();
            unset($examen);
            return NULL;
        }
    }

    public function create()
    {
        $this->insertRow("INSERT INTO optica.examenes VALUES (NULL, ?, ?)", array(
                $this->nombre,
                $this->descripcion,
            )
        );
        $this->Disconnect();
    }

    public function update()
    {
        $this->updateRow("UPDATE optica.examenes SET nombre = ?, descripcion = ?  WHERE idExamenes = ?", array(
                $this->nombre,
                $this->descripcion,
                $this->idExamenes
            )
        );
        $this->Disconnect();
    }

    public function deleted($id)
    {
        // TODO: Implement deleted() method.
    }
}