<?php
namespace App\Modelo;
require_once ('db_abstract_class.php');

class ExamenHistorial extends db_abstract_class
{
    private $IdExamenHistorial;
    private $examen_id;
    private $id_cita_examen;
    private $valores;

    /**
     * persona constructor.
     * @param $IdExamenHistorial
     * @param $examen_id
     * @param $id_cita_examen
     * @param $valores
     */
    public function __construct($ExamenHistorial=array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->IdExamenHistorial = $ExamenHistorial ['IdExamenHistorial'] ?? null;
        $this->examen_id = $ExamenHistorial ['examen_id'] ?? null;
        $this->id_cita_examen = $ExamenHistorial ['id_cita_examen'] ?? null;
        $this->valores = $ExamenHistorial ['valores'] ?? null;

        if ($this->valores!=null){
           $this->valores= json_encode($ExamenHistorial ['valores']);
        }

        if ($this->examen_id!=null){
            $this->examen_id = Examen::searchForId($this->examen_id);
        }

        if ($this->id_cita_examen!=null){
            $this->id_cita_examen = Cita::searchForId($this->id_cita_examen);
        }
    }

    /**
     * @return mixed|null
     */
    public function getIdExamenHistorial()
    {
        return $this->IdExamenHistorial;
    }

    /**
     * @param null $IdExamenHistorial
     */
    public function setIdExamenHistorial( $IdExamenHistorial): void
    {
        $this->IdExamenHistorial = $IdExamenHistorial;
    }

    /**
     * @return Examen|null
     */
    public function getExamenId(): ?Examen
    {
        return $this->examen_id;
    }

    /**
     * @param Examen|null $examen_id
     */
    public function setExamenId(?Examen $examen_id): void
    {
        $this->examen_id = $examen_id;
    }

    /**
     * @return Cita|null
     */
    public function getIdCitaExamen(): ?Cita
    {
        return $this->id_cita_examen;
    }

    /**
     * @param Cita|null $id_cita_examen
     */
    public function setIdCitaExamen(?Cita $id_cita_examen): void
    {
        $this->id_cita_examen = $id_cita_examen;
    }

    /**
     * @return mixed|null
     */
    public function getValores()
    {
        return $this->valores;
    }

    /**
     * @param null $valores
     */
    public function setValores( $valores): void
    {
        $this->valores = $valores;
    }



    public static function search($query)
    {
        $ArrExamenHistorial = array();
        $tmp = new ExamenHistorial();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $examenHistorial = new ExamenHistorial();
            $examenHistorial->IdExamenHistorial = $valor['IdExamenHistorial'];
            $examenHistorial->examen_id = Examen::searchForId($valor['examen_id']);
            $examenHistorial->id_cita_examen = Cita::searchForId($valor['id_cita_examen']);
            $examenHistorial->valores = $valor['valores'];
            $examenHistorial->Disconnect();
            array_push($ArrExamenHistorial, $examenHistorial);
        }
        $tmp->Disconnect();
        return $ArrExamenHistorial;
    }

    public static function getAll()
    {
        return ExamenHistorial::search("SELECT * FROM optica.examenes_historial");
    }

    public static function searchForId($idExamenHistorial)
    {
        $examenHistorial = new ExamenHistorial();
        if ($idExamenHistorial > 0){
            $getrow = $examenHistorial->getRow("SELECT * FROM optica.examenes_historial WHERE IdExamenHistorial =?", array($idExamenHistorial));
            $examenHistorial->IdExamenHistorial = $getrow['IdExamenHistorial'];
            $examenHistorial->examen_id = Examen::searchForId($getrow['examen_id']);
            $examenHistorial->id_cita_examen = Cita::searchForId($getrow['id_cita_examen']);
            $examenHistorial->valores = $getrow['valores'];
            $examenHistorial->Disconnect();
            return $examenHistorial;
        }else{
            $examenHistorial->Disconnect();
            unset($examenHistorial);
            return NULL;
        }
    }

    public function create()
    {
        $this->insertRow("INSERT INTO optica.examenes_historial VALUES (NULL, ?, ?, ?)", array(
                $this->examen_id->getIdExamenes(),
                $this->id_cita_examen->getIdCita(),
                $this->valores
            )
        );
        $last_id= $this->getLastId();
        $this->Disconnect();
        return $last_id;
    }

    public function update()
    {
        $this->updateRow("UPDATE optica.examenes_historial SET examen_id = ?, valores = ?  WHERE IdExamenHistorial = ?", array(
                $this->examen_id->getIdExamenes(),
                $this->valores,
                $this->IdExamenHistorial
            )
        );
        $this->Disconnect();
    }

    public function deleted($id)
    {
        $this->updateRow("UPDATE optica.examenes_historial SET id_cita_examen = null  WHERE IdExamenHistorial = ? ", array(
            $id
        ) );
        $this->Disconnect();
    }
}