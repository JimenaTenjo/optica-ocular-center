<?php


namespace App\Modelo;
require_once ('db_abstract_class.php');
require_once ('PrescripcionFinal.php');

use  App\Modelo\Cita;

class FormulaMedica extends db_abstract_class
{

    private $idFormulamedica;
    private $fecha;
    private $descripcion;
    private $id_prescripcion_formula;

    /**
     * formula_medica constructor.
     * @param $idFormulamedica
     * @param $fecha
     * @param $descripcion
     * @param $id_cita_formula
     */
    public function __construct($FormulaMedica = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->idFormulamedica = $FormulaMedica ['idFormulamedica'] ?? null;
        $this->fecha = $FormulaMedica ['fecha'] ?? null;
        $this->descripcion = $FormulaMedica ['descripcion'] ?? null;
        $this->id_prescripcion_formula = $FormulaMedica ['id_prescripcion_formula'] ?? null;

        if($this->id_prescripcion_formula!=null){
            $this->id_prescripcion_formula = PrescripcionFinal::searchForId( $FormulaMedica ['id_prescripcion_formula']);
        }

    }

    /**
     * @return null
     */
    public function getIdFormulamedica()
    {
        return $this->idFormulamedica;
    }

    /**
     * @param null $idFormulamedica
     */
    public function setIdFormulamedica( $idFormulamedica): void
    {
        $this->idFormulamedica = $idFormulamedica;
    }

    /**
     * @return null
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param null $fecha
     */
    public function setFecha( $fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed|null
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

    /**
     * @return PrescripcionFinal|null
     */
    public function getIdPrescripcionFormula(): ?PrescripcionFinal
    {
        return $this->id_prescripcion_formula;
    }

    /**
     * @param PrescripcionFinal|null $id_prescripcion_formula
     */
    public function setIdPrescripcionFormula(?PrescripcionFinal $id_prescripcion_formula): void
    {
        $this->id_prescripcion_formula = $id_prescripcion_formula;
    }





    public static function search($query)
    {
        $ArrFormulaMedica = array();
        $tmp = new FormulaMedica();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $formulaMedica = new FormulaMedica();
            $formulaMedica->idFormulamedica = $valor['idFormulamedica'];
            $formulaMedica->fecha = Examen::searchForId($valor['fecha']);
            $formulaMedica->descripcion = Cita::searchForId($valor['descripcion']);
            $formulaMedica->id_prescripcion_formula = PrescripcionFinal::searchForId($valor['id_prescripcion_formula']);
            $formulaMedica->Disconnect();
            array_push($ArrFormulaMedica, $formulaMedica);
        }
        $tmp->Disconnect();
        return $ArrFormulaMedica;
    }

    public static function getAll()
    {
        return FormulaMedica::search("SELECT * FROM optica.formula_medica");
    }

    public static function searchForId($idFormulaMedica)
    {
        $formulaMedica = new FormulaMedica();
        if ($idFormulaMedica > 0) {
            $getrow = $formulaMedica->getRow("SELECT * FROM optica.formula_medica WHERE idFormulamedica =?", array($idFormulaMedica));
            $formulaMedica->idFormulamedica = $getrow['idFormulamedica'];
            $formulaMedica->fecha = $getrow['fecha'];
            $formulaMedica->descripcion = $getrow['descripcion'];
            $formulaMedica->id_prescripcion_formula = PrescripcionFinal::searchForId($getrow['prescripcion_formula_id']);
            $formulaMedica->Disconnect();
            return $formulaMedica;
        } else {
            $formulaMedica->Disconnect();
            unset($formulaMedica);
            return NULL;
        }
    }

    public function create()
    {
        $this->insertRow("INSERT INTO optica.formula_medica VALUES (NULL, ?, ?, ?)", array(
                $this->fecha,
                $this->descripcion,
                $this->id_prescripcion_formula->getIdPrescripcionFinal()
            )
        );
        $last_id = $this->getLastId();
        $this->Disconnect();
        return $last_id;
    }

    public function update()
    {
        $this->updateRow("UPDATE optica.formula_medica SET descripcion = ? WHERE idFormulamedica = ?", array(
                $this->descripcion,
                $this->idFormulamedica
            )
        );
        $this->Disconnect();
    }

    public function deleted($id)
    {

    }

}