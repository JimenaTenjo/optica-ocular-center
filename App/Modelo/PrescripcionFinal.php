<?php


namespace App\Modelo;
require_once ('db_abstract_class.php');

class PrescripcionFinal extends db_abstract_class
{
    private $idPrescripcion_Final;
    private $OI;
    private $OD;
    private $ADD_OD;
    private $ADD_OI;
    private $AV_VL_OD;
    private $AV_VL_OI;
    private $AV_VP_OD;
    private $AV_VP_OI;
    private $DNP_OD;
    private $DNP_OI;

    /**
     * persona constructor.
     * @param $idPrescripcion_Final
     * @param $OI
     * @param $OD
     * @param $ADD_OD
     * @param $ADD_OI
     * @param $AV_VL_OD
     * @param $AV_VL_OI
     * @param $AV_VP_OD
     * @param $AV_VP_OI
     * @param $DNP_OD
     * @param $DNP_OI
     */

    public function __construct($PrescripcionFinal=array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->idPrescripcion_Final = $PrescripcionFinal ['idPrescripcion_Final'] ?? null;
        $this->OI = $PrescripcionFinal ['OI'] ?? null;
        $this->OD = $PrescripcionFinal ['OD'] ?? null;
        $this->ADD_OD = $PrescripcionFinal ['ADD_OD'] ?? null;
        $this->ADD_OI = $PrescripcionFinal ['ADD_OI'] ?? null;
        $this->AV_VL_OD = $PrescripcionFinal ['AV_VL_OD'] ?? null;
        $this->AV_VL_OI = $PrescripcionFinal ['AV_VL_OI'] ?? null;
        $this->AV_VP_OD = $PrescripcionFinal ['AV_VP_OD'] ?? null;
        $this->AV_VP_OI = $PrescripcionFinal ['AV_VP_OI'] ?? null;
        $this->DNP_OD = $PrescripcionFinal ['DNP_OD'] ?? null;
        $this->DNP_OI = $PrescripcionFinal ['DNP_OI'] ?? null;
    }

    /**
     * @return null
     */
    public function getIdPrescripcionFinal()
    {
        return $this->idPrescripcion_Final;
    }

    /**
     * @param null $idPrescripcion_Final
     */
    public function setIdPrescripcionFinal( $idPrescripcion_Final): void
    {
        $this->idPrescripcion_Final = $idPrescripcion_Final;
    }

    /**
     * @return null
     */
    public function getOI()
    {
        return $this->OI;
    }

    /**
     * @param null $OI
     */
    public function setOI( $OI): void
    {
        $this->OI = $OI;
    }

    /**
     * @return null
     */
    public function getOD()
    {
        return $this->OD;
    }

    /**
     * @param null $OD
     */
    public function setOD( $OD): void
    {
        $this->OD = $OD;
    }

    /**
     * @return null
     */
    public function getADDOD()
    {
        return $this->ADD_OD;
    }

    /**
     * @param null $ADD_OD
     */
    public function setADDOD( $ADD_OD): void
    {
        $this->ADD_OD = $ADD_OD;
    }

    /**
     * @return null
     */
    public function getADDOI()
    {
        return $this->ADD_OI;
    }

    /**
     * @param null $ADD_OI
     */
    public function setADDOI( $ADD_OI): void
    {
        $this->ADD_OI = $ADD_OI;
    }

    /**
     * @return null
     */
    public function getAVVLOD()
    {
        return $this->AV_VL_OD;
    }

    /**
     * @param null $AV_VL_OD
     */
    public function setAVVLOD( $AV_VL_OD): void
    {
        $this->AV_VL_OD = $AV_VL_OD;
    }

    /**
     * @return null
     */
    public function getAVVLOI()
    {
        return $this->AV_VL_OI;
    }

    /**
     * @param null $AV_VL_OI
     */
    public function setAVVLOI( $AV_VL_OI): void
    {
        $this->AV_VL_OI = $AV_VL_OI;
    }

    /**
     * @return null
     */
    public function getAVVPOD()
    {
        return $this->AV_VP_OD;
    }

    /**
     * @param null $AV_VP_OD
     */
    public function setAVVPOD( $AV_VP_OD): void
    {
        $this->AV_VP_OD = $AV_VP_OD;
    }

    /**
     * @return null
     */
    public function getAVVPOI()
    {
        return $this->AV_VP_OI;
    }

    /**
     * @param null $AV_VP_OI
     */
    public function setAVVPOI( $AV_VP_OI): void
    {
        $this->AV_VP_OI = $AV_VP_OI;
    }

    /**
     * @return null
     */
    public function getDNPOD()
    {
        return $this->DNP_OD;
    }

    /**
     * @param null $DNP_OD
     */
    public function setDNPOD( $DNP_OD): void
    {
        $this->DNP_OD = $DNP_OD;
    }

    /**
     * @return null
     */
    public function getDNPOI()
    {
        return $this->DNP_OI;
    }

    /**
     * @param null $DNP_OI
     */
    public function setDNPOI( $DNP_OI): void
    {
        $this->DNP_OI = $DNP_OI;
    }




    public static function search($query)
    {
        $ArrPrescripcionFinal = array();
        $tmp = new PrescripcionFinal();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $prescripcion_final = new PrescripcionFinal();
            $prescripcion_final->idPrescripcion_Final = $valor['idPrescripcion_Final'];
            $prescripcion_final->OI = $valor['OI'];
            $prescripcion_final->OD = $valor['OD'];
            $prescripcion_final->ADD_OD = $valor['ADD_OD'];
            $prescripcion_final->ADD_OI = $valor['ADD_OI'];
            $prescripcion_final->AV_VL_OD = $valor['AV_VL_OD'];
            $prescripcion_final->AV_VL_OI = $valor['AV_VL_OI'];
            $prescripcion_final->AV_VP_OD = $valor['AV_VP_OD'];
            $prescripcion_final->AV_VP_OI = $valor['AV_VP_OI'];
            $prescripcion_final->DNP_OD= $valor['DNP_OD'];
            $prescripcion_final->DNP_OI = $valor['DNP_OI'];
            $prescripcion_final->Disconnect();
            array_push($ArrPrescripcionFinal, $prescripcion_final);
        }
        $tmp->Disconnect();
        return $ArrPrescripcionFinal;
    }

    public static function getAll()
    {
        return PrescripcionFinal::search("SELECT * FROM optica.prescripcion_final");
    }

    public static function searchForId($idPrescripcionFinal)
    {
        $prescripcion_final = new PrescripcionFinal();
        if ($idPrescripcionFinal > 0){
            $getrow = $prescripcion_final->getRow("SELECT * FROM optica.prescripcion_final WHERE idPrescripcion_Final =?", array($idPrescripcionFinal));
            $prescripcion_final->idPrescripcion_Final = $getrow['idPrescripcion_Final'];
            $prescripcion_final->OI = $getrow['OI'];
            $prescripcion_final->OD = $getrow['OD'];
            $prescripcion_final->ADD_OD = $getrow['ADD_OD'];
            $prescripcion_final->ADD_OI = $getrow['ADD_OI'];
            $prescripcion_final->AV_VL_OD = $getrow['AV_VL_OD'];
            $prescripcion_final->AV_VL_OI = $getrow['AV_VL_OI'];
            $prescripcion_final->AV_VP_OD = $getrow['AV_VP_OD'];
            $prescripcion_final->AV_VP_OI = $getrow['AV_VP_OI'];
            $prescripcion_final->DNP_OD= $getrow['DNP_OD'];
            $prescripcion_final->DNP_OI = $getrow['DNP_OI'];
            $prescripcion_final->Disconnect();
            return $prescripcion_final;
        }else{
            $prescripcion_final->Disconnect();
            unset($prescripcion_final);
            return NULL;
        }
    }

    public function create()
    {
        $this->insertRow("INSERT INTO optica.prescripcion_final VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
            $this->OI,
            $this->OD,
            $this->ADD_OD,
            $this->ADD_OI,
            $this->AV_VL_OD,
            $this->AV_VL_OI,
            $this->AV_VP_OD,
            $this->AV_VP_OI,
            $this->DNP_OD,
            $this->DNP_OI ,
            )
        );
        $last_id= $this->getLastId();
        $this->Disconnect();
        return $last_id;
    }

    public function update()
    {
        $this->updateRow("UPDATE optica.prescripcion_final SET OI = ?, OD = ?, ADD_OD = ?, ADD_OI = ?, AV_VL_OD = ?,
                        AV_VL_OI = ?, AV_VP_OD = ?, AV_VP_OI = ?, DNP_OD = ?, DNP_OI = ?  WHERE idPrescripcion_Final = ?", array(
                $this->OI,
                $this->OD,
                $this->ADD_OD,
                $this->ADD_OI,
                $this->AV_VL_OD,
                $this->AV_VL_OI,
                $this->AV_VP_OD,
                $this->AV_VP_OI,
                $this->DNP_OD,
                $this->DNP_OI ,
                $this->idPrescripcion_Final
            )
        );
        $this->Disconnect();
    }

    public function deleted($id)
    {
        // TODO: Implement deleted() method.
    }
}