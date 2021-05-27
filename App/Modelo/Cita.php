<?php
namespace App\Modelo;
require_once ('db_abstract_class.php');
require_once ('Paciente.php');
require_once ('Medico.php');
require_once ('MotivoConsulta.php');
use App\Modelo\Paciente;
use App\Modelo\Medico;

class Cita extends db_abstract_class
{
    private $idCita;
    private $fecha;
    private $hora;
    private $medico_cita_id;
    private $paciente_cita_id;
    private $motivo_consulta_id;
    private $estado;

    /**
     * Cita constructor.
     * @param $idCita
     * @param $fecha
     * @param $hora
     * @param $medico_cita_id
     * @param $paciente_cita_id
     * @param $motivo_consulta_id
     * @param $estado
     */
    public function __construct($Cita= array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->idCita= $Cita['idCita'] ?? null;
        $this->fecha = $Cita['fecha'] ?? null;
        $this->hora = $Cita['hora'] ?? null;
        $this->medico_cita_id = $Cita['medico_cita_id'] ?? null;
        $this->paciente_cita_id = $Cita['paciente_cita_id'] ?? null;
        $this->motivo_consulta_id =$Cita['motivo_consulta_id'] ?? null;
        $this->estado = $Cita['estado'] ?? null;

        if($this->motivo_consulta_id!=null){
            $this->motivo_consulta_id = MotivoConsulta::searchForId($Cita['motivo_consulta_id']);
        }
        if($this->medico_cita_id!=null){
            $this->medico_cita_id = Medico::searchForId($Cita['medico_cita_id']);
        }

        if($this->paciente_cita_id!=null){
            $this->paciente_cita_id = Paciente::searchForId($Cita['paciente_cita_id']);
        }

    }

    /* Metodo destructor cierra la conexion. */
    function __destruct() {
        $this->Disconnect();
    }

    /**
     * @return mixed|null
     */
    public function getIdCita()
    {
        return $this->idCita;
    }

    /**
     * @param mixed|null $idCita
     */
    public function setIdCita( $idCita): void
    {
        $this->idCita = $idCita;
    }

    /**
     * @return mixed|null
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed|null $fecha
     */
    public function setFecha( $fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed|null
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * @param mixed|null $hora
     */
    public function setHora( $hora): void
    {
        $this->hora = $hora;
    }

    /**
     * @return Medico|null
     */
    public function getMedicoCitaId(): ?Medico
    {
        return $this->medico_cita_id;
    }

    /**
     * @param Medico|null $medico_cita_id
     */
    public function setMedicoCitaId(?Medico $medico_cita_id): void
    {
        $this->medico_cita_id = $medico_cita_id;
    }

    /**
     * @return Paciente|null
     */
    public function getPacienteCitaId(): ?Paciente
    {
        return $this->paciente_cita_id;
    }

    /**
     * @param Paciente|null $paciente_cita_id
     */
    public function setPacienteCitaId(?Paciente $paciente_cita_id): void
    {
        $this->paciente_cita_id = $paciente_cita_id;
    }

    /**
     * @return mixed|null
     */
    public function getMotivoConsultaid() : MotivoConsulta
    {
        return $this->motivo_consulta_id;
    }

    /**
     * @param mixed|null $motivo_consulta_id
     */
    public function setMotivoConsultaid($motivo_consulta_id): void
    {
        $this->motivo_consulta_id = $motivo_consulta_id;
    }

    /**
     * @return mixed|null
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed|null $estado
     */
    public function setEstado( $estado): void
    {
        $this->estado = $estado;
    }



    public static function search($query)
    {
        $arrCitas = array();
        $tmp = new Cita();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $Cita = new Cita();
            $Cita->idCita = $valor['idCita'];
            $Cita->fecha = $valor['fecha'];
            $Cita->hora = $valor['hora'];
            $Cita->estado = $valor['estado'];
            $Cita->paciente_cita_id = Paciente::searchForId($valor['paciente_cita_id']);
            $Cita->motivo_consulta_id = MotivoConsulta::searchForId($valor['motivo_consulta_id']);
            $Cita->medico_cita_id = Medico::searchForId($valor['medico_cita_id']);
            $Cita->Disconnect();
            array_push($arrCitas, $Cita);
        }
        $tmp->Disconnect();
        return $arrCitas;
    }

    public static function getAll()
    {
        return Cita::search("SELECT * FROM optica.citas");
    }

    public static function searchForId($id)
    {
        $Cita = new Cita();
        if ($id > 0){
            $getrow = $Cita->getRow("SELECT * FROM optica.citas WHERE idCita =?", array($id));
            $Cita->idCita = $getrow['idCita'];
            $Cita->fecha = $getrow['fecha'];
            $Cita->hora = $getrow['hora'];
            $Cita->estado = $getrow['estado'];
            $Cita->paciente_cita_id = Paciente::searchForId($getrow['paciente_cita_id']);
            $Cita->motivo_consulta_id = MotivoConsulta::searchForId($getrow['motivo_consulta_id']);
            $Cita->medico_cita_id = Medico::searchForId($getrow['medico_cita_id']);
            $Cita->Disconnect();
            return $Cita;
        }else{
            $Cita->Disconnect();
            unset($Cita);
            return NULL;
        }
    }


    public function create()
    {
        $result= $this->insertRow("INSERT INTO optica.citas VALUES (NULL, ?, ?, ?, ?, ?, ?)", array(
                $this->fecha,
                $this->hora,
                $this->estado,
                $this->motivo_consulta_id->getIdMotivoConsulta(),
                $this->paciente_cita_id->getIdPaciente(),
                $this->medico_cita_id->getIdMedico(),
            )
        );
        $this->Disconnect();
        return $result;
    }

    public function update()
    {

        $result = $this->updateRow("UPDATE optica.citas SET fecha = ?, hora = ?, estado = ?, motivo_consulta_id = ?, paciente_cita_id = ?, medico_cita_id = ?   WHERE idCita = ?", array(
                $this->fecha,
                $this->hora,
                $this->estado,
                $this->paciente_cita_id->getIdPaciente(),
                $this->motivo_consulta_id->getIdMotivoConsulta(),
                $this->medico_cita_id->getIdMedico(),
                $this->idCita
            )
        );
        $this->Disconnect();
        return $result;

    }

    public function deleted($id)
    {
        // TODO: Implement deleted() method.
    }

    public static function citaRegistrada ($idPaciente) : bool
    {
        $result = Cita::search("SELECT * FROM optica.citas 
                                        WHERE optica.citas.paciente_cita_id ='". $idPaciente ."'AND optica.citas.estado = 'Activo' ");
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
}