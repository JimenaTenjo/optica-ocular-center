<?php


namespace App\Modelo;
require_once ('db_abstract_class.php');
require_once ('PrescripcionFinal.php');
require_once ('Cita.php');
use App\Modelo\PrescripcionFinal;
use App\Modelo\Cita;


class Historial extends db_abstract_class
{
    private $idHistorial;
    private $codigo_rips;
    private $conducta;
    private $control;
    private $citas_historial_id;
    private $diagnostico;
    private $anamnesis;
    private $antecedentes;
    private $prescripcion_historial_id;
    private $nombre_acudiente;
    private $telefono_acudiente;

    /**
     * persona constructor.
     * @param $idHistorial
     * @param $codigo_rips
     * @param $conducta
     * @param $control
     * @param $citas_historial_id
     * @param $diagnostico
     * @param $anamnesis
     * @param $antecedentes
     * @param $prescripcion_historial_id
     * @param $nombre_acudiente
     * @param $telefono_acudiente
     */
    public function __construct($Historial=array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->idHistorial = $Historial ['idHistorial'] ?? null;
        $this->codigo_rips = $Historial ['codg_rips'] ?? null;
        $this->conducta = $Historial ['conducta'] ?? null;
        $this->control = $Historial ['control'] ?? null;
        $this->citas_historial_id = $Historial ['citas_historial_id'] ?? null;
        $this->diagnostico = $Historial ['diagnostico'] ?? null;
        $this->anamnesis = $Historial ['anamnesis'] ?? null;
        $this->antecedentes = $Historial ['antecedentes'] ?? null;
        $this->prescripcion_historial_id = $Historial ['prescripcion_historial_id'] ?? null;
        $this->nombre_acudiente = $Historial ['nombre_acuediente'] ?? null;
        $this->telefono_acudiente = $Historial ['telefono_acudiente'] ?? null;

        if ($this->citas_historial_id!=null){
            $this->citas_historial_id = Cita::searchForId($this->citas_historial_id);
        }
        if ($this->prescripcion_historial_id!=null){
            $this->prescripcion_historial_id = PrescripcionFinal::searchForId($this->prescripcion_historial_id);
        }
    }

    /**
     * @return null
     */
    public function getIdHistorial()
    {
        return $this->idHistorial;
    }

    /**
     * @param null $idHistorial
     */
    public function setIdHistorial($idHistorial): void
    {
        $this->idHistorial = $idHistorial;
    }

    /**
     * @return null
     */
    public function getCodigoRips()
    {
        return $this->codigo_rips;
    }

    /**
     * @param null $codigo_rips
     */
    public function setCodigoRips( $codigo_rips): void
    {
        $this->codigo_rips = $codigo_rips;
    }

    /**
     * @return null
     */
    public function getConducta()
    {
        return $this->conducta;
    }

    /**
     * @param null $conducta
     */
    public function setConducta( $conducta): void
    {
        $this->conducta = $conducta;
    }

    /**
     * @return null
     */
    public function getControl()
    {
        return $this->control;
    }

    /**
     * @param null $control
     */
    public function setControl( $control): void
    {
        $this->control = $control;
    }

    /**
     * @return Cita|null
     */
    public function getCitasHistorialId(): ?Cita
    {
        return $this->citas_historial_id;
    }

    /**
     * @param Cita|null $citas_historial_id
     */
    public function setCitasHistorialId(?Cita $citas_historial_id): void
    {
        $this->citas_historial_id = $citas_historial_id;
    }

    /**
     * @return null
     */
    public function getDiagnostico()
    {
        return $this->diagnostico;
    }

    /**
     * @param null $diagnostico
     */
    public function setDiagnostico($diagnostico): void
    {
        $this->diagnostico = $diagnostico;
    }

    /**
     * @return null
     */
    public function getAnamnesis()
    {
        return $this->anamnesis;
    }

    /**
     * @param null $anamnesis
     */
    public function setAnamnesis($anamnesis): void
    {
        $this->anamnesis = $anamnesis;
    }

    /**
     * @return null
     */
    public function getAntecedentes()
    {
        return $this->antecedentes;
    }

    /**
     * @param null $antecedentes
     */
    public function setAntecedentes($antecedentes): void
    {
        $this->antecedentes = $antecedentes;
    }

    /**
     * @return Cita|null
     */
    public function getPrescripcionHistorialId(): ?PrescripcionFinal
    {
        return $this->prescripcion_historial_id;
    }

    /**
     * @param Cita|null $prescripcion_historial_id
     */
    public function setPrescripcionHistorialId(?PrescripcionFinal $prescripcion_historial_id): void
    {
        $this->prescripcion_historial_id = $prescripcion_historial_id;
    }

    /**
     * @return null
     */
    public function getNombreAcudiente()
    {
        return $this->nombre_acudiente;
    }

    /**
     * @param null $nombre_acudiente
     */
    public function setNombreAcudiente($nombre_acudiente): void
    {
        $this->nombre_acudiente = $nombre_acudiente;
    }

    /**
     * @return null
     */
    public function getTelefonoAcudiente()
    {
        return $this->telefono_acudiente;
    }

    /**
     * @param null $telefono_acudiente
     */
    public function setTelefonoAcudiente($telefono_acudiente): void
    {
        $this->telefono_acudiente = $telefono_acudiente;
    }


    public static function search($query) : array
    {
        $ArrHistorial = array();
        $tmp = new Historial();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $historial = new Historial();
            $historial->idHistorial = $valor['idHistorial'];
            $historial->codigo_rips = $valor['codg_rips'];
            $historial->conducta = $valor['conducta'];
            $historial->control = $valor['control'];
            $historial->citas_historial_id = Cita::searchForId($valor['citas_historial_id']);
            $historial->diagnostico = $valor['diagnostico'];
            $historial->anamnesis = $valor['anamnesis'];
            $historial->antecedentes = $valor['antecedentes'];
            $historial->prescripcion_historial_id = PrescripcionFinal::searchForId($valor['prescripcion_historial_id']);
            $historial->nombre_acudiente = $valor['nombre_acudiente'];
            $historial->telefono_acudiente = $valor['telefono_acudiente'];
            $historial->Disconnect();
            array_push($ArrHistorial, $historial);
        }
        $tmp->Disconnect();
        return $ArrHistorial;
    }

    public static function getAll()
    {
        return Historial::search("SELECT * FROM optica.historial");
    }

    public static function searchForId($idHistorial)
    {
        $historial = new Historial();
        if ($idHistorial > 0){
            $getrow = $historial->getRow("SELECT * FROM optica.historial WHERE idHistorial =?", array($idHistorial));
            $historial->idHistorial = $getrow['idHistorial'];
            $historial->codigo_rips = $getrow['codg_rips'];
            $historial->conducta = $getrow['conducta'];
            $historial->control = $getrow['control'];
            $historial->citas_historial_id = Cita::searchForId($getrow['citas_historial_id']);
            $historial->diagnostico = $getrow['diagnostico'];
            $historial->anamnesis = $getrow['anamnesis'];
            $historial->antecedentes = $getrow['antecedentes'];
            $historial->prescripcion_historial_id = PrescripcionFinal::searchForId($getrow['prescripcion_historial_id']);
            $historial->nombre_acudiente = $getrow['nombre_acudiente'];
            $historial->telefono_acudiente = $getrow['telefono_acudiente'];
            $historial->Disconnect();
            return $historial;
        }else{
            $historial->Disconnect();
            unset($historial);
            return NULL;
        }
    }

    public function create()
    {
        print_r($this->prescripcion_historial_id->getIdPrescripcionFinal());
        $this->insertRow("INSERT INTO optica.historial VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
                $this->codigo_rips,
                $this->conducta,
                $this->control,
                $this->citas_historial_id->getIdCita(),
                $this->diagnostico,
                $this->anamnesis,
                $this->antecedentes,
                $this->prescripcion_historial_id->getIdPrescripcionFinal(),
                $this->nombre_acudiente,
                $this->telefono_acudiente,
            )
        );
        $lastId= $this->getLastId();
        $this->Disconnect();
        return $lastId;
    }

    public function update()
    {
        $this->updateRow("UPDATE optica.historial SET codigo_rips = ?, conducta = ?, control = ?, citas_historial_id = ?, diagnostico = ?,
                        anamnesis = ?, antecedentes = ?, prescripcion_historial_id = ?, nombre_acudiente = ?, telefono_acudiente = ?  WHERE idHistorial = ?", array(
                $this->codigo_rips,
                $this->conducta,
                $this->control,
                $this->citas_historial_id->getIdCita(),
                $this->diagnostico,
                $this->anamnesis,
                $this->antecedentes,
                $this->prescripcion_historial_id,
                $this->nombre_acudiente,
                $this->telefono_acudiente,
                $this->idHistorial
            )
        );
        $this->Disconnect();
    }

    public function deleted($id)
    {
        // TODO: Implement deleted() method.
    }
}
