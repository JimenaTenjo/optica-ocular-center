<?php
namespace App\Modelo;
require_once ('db_abstract_class.php');

class Paciente extends db_abstract_class
{
    private $idPaciente;
    private $ocupacion;
    private $estado_civil;
    private $tipo_afiliacion;
    private $tipo_vinculacion;
    private $fecha_ultima_cita;
    private $id_persona_paciente;




    /**
     * persona constructor.
     * @param $idPaciente
     * @param $ocupacion
     * @param $estado_civil
     * @param $tipo_afiliacion
     * @param $tipo_vinculacion
     * @param $fecha_ultima_cita
     * @param $id_persona_paciente
     */
    public function __construct($Paciente=array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->idPaciente = $Paciente ['idPaciente'] ?? null;
        $this->ocupacion = $Paciente ['ocupacion'] ?? null;
        $this->estado_civil = $Paciente ['estado_civil'] ?? null;
        $this->tipo_afiliacion = $Paciente ['tipo_afiliacion'] ?? null;
        $this->tipo_vinculacion = $Paciente ['tipo_vinculacion'] ?? null;
        $this->fecha_ultima_cita = $Paciente ['fecha_ultima_cita'] ?? null;
        $this->id_persona_paciente = $Paciente ['id_persona_paciente'] ?? null;
        if($this->id_persona_paciente!=null){
            $this->id_persona_paciente = Persona::searchForId($Paciente ['id_persona_paciente']);
        }
    }

    /**
     * @return mixed|null
     */
    public function getIdPaciente()
    {
        return $this->idPaciente;
    }

    /**
     * @param mixed|null $idPaciente
     */
    public function setIdPaciente( $idPaciente): void
    {
        $this->idPaciente = $idPaciente;
    }

    /**
     * @return mixed|null
     */
    public function getOcupacion()
    {
        return $this->ocupacion;
    }

    /**
     * @param mixed|null $ocupacion
     */
    public function setOcupacion( $ocupacion): void
    {
        $this->ocupacion = $ocupacion;
    }

    /**
     * @return mixed|null
     */
    public function getEstadoCivil()
    {
        return $this->estado_civil;
    }

    /**
     * @param mixed|null $estado_civil
     */
    public function setEstadoCivil( $estado_civil): void
    {
        $this->estado_civil = $estado_civil;
    }

    /**
     * @return mixed|null
     */
    public function getTipoAfiliacion()
    {
        return $this->tipo_afiliacion;
    }

    /**
     * @param mixed|null $tipo_afiliacion
     */
    public function setTipoAfiliacion( $tipo_afiliacion): void
    {
        $this->tipo_afiliacion = $tipo_afiliacion;
    }

    /**
     * @return mixed|null
     */
    public function getTipoVinculacion()
    {
        return $this->tipo_vinculacion;
    }

    /**
     * @param mixed|null $tipo_vinculacion
     */
    public function setTipoVinculacion( $tipo_vinculacion): void
    {
        $this->tipo_vinculacion = $tipo_vinculacion;
    }

    /**
     * @return mixed|null
     */
    public function getFechaUltimaCita()
    {
        return $this->fecha_ultima_cita;
    }

    /**
     * @param mixed|null $fecha_ultima_cita
     */
    public function setFechaUltimaCita( $fecha_ultima_cita): void
    {
        $this->fecha_ultima_cita = $fecha_ultima_cita;
    }

    /**
     * @return mixed|null
     */
    public function getIdPersonaPaciente(): Persona
    {
        return $this->id_persona_paciente;
    }

    /**
     * @param mixed|null $id_persona_paciente
     */
    public function setIdPersonaPaciente( $id_persona_paciente): void
    {
        $this->id_persona_paciente = $id_persona_paciente;
    }



    public function create()
    {
        $this->insertRow("INSERT INTO optica.paciente VALUES (NULL, ?, ?, ?, ?, ?, ?)", array(
                $this->ocupacion,
                $this->estado_civil,
                $this->tipo_afiliacion,
                $this->tipo_vinculacion,
                $this->fecha_ultima_cita,
                $this->id_persona_paciente->getIdPersona(),
            )
        );
        $this->Disconnect();
    }

    public function update()
    {
        $this->updateRow("UPDATE optica.paciente SET ocupacion = ?, estado_civil = ?, tipo_afiliacion = ?, tipo_vinculacion = ?, fecha_ultima_cita = ?, id_persona_paciente = ? WHERE idPaciente = ?", array(
                $this->ocupacion,
                $this->estado_civil,
                $this->tipo_afiliacion,
                $this->tipo_vinculacion,
                $this->fecha_ultima_cita,
                $this->id_persona_paciente->getIdPersona(),
                $this->idPaciente
            )
        );
        $this->Disconnect();
    }

    public function deleted($idPersona)
    {
        // TODO: Implement deleted() method.
    }

    public static function search($query) : array
    {
        $ArrPaciente = array();
        $tmp = new Paciente();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $paciente = new Paciente();
            $paciente->idPaciente = $valor['idPaciente'];
            $paciente->ocupacion = $valor['ocupacion'];
            $paciente->estado_civil = $valor['estado_civil'];
            $paciente->tipo_afiliacion = $valor['tipo_afiliacion'];
            $paciente->tipo_vinculacion = $valor['tipo_vinculacion'];
            $paciente->fecha_ultima_cita = $valor['fecha_ultima_cita'];
            $paciente->id_persona_paciente = Persona::searchForId($valor['id_persona_paciente']);
            $paciente->Disconnect();
            array_push($ArrPaciente, $paciente);
        }
        $tmp->Disconnect();
        return $ArrPaciente;
    }

    public static function searchForId($idPaciente)
    {
        $paciente = new Paciente();
        if ($idPaciente > 0){
            $getrow = $paciente->getRow("SELECT * FROM optica.paciente WHERE idPaciente =?", array($idPaciente));
            $paciente->idPaciente = $getrow['idPaciente'];
            $paciente->ocupacion = $getrow['ocupacion'];
            $paciente->estado_civil = $getrow['estado_civil'];
            $paciente->tipo_afiliacion = $getrow['tipo_afiliacion'];
            $paciente->tipo_vinculacion = $getrow['tipo_vinculacion'];
            $paciente->fecha_ultima_cita = $getrow['fecha_ultima_cita'];
            $paciente->id_persona_paciente = Persona::searchForId($getrow['id_persona_paciente']);
            $paciente->Disconnect();
            return $paciente;
        }else{
            $paciente->Disconnect();
            unset($paciente);
            return NULL;
        }
    }

    public static function getAll() : array
    {
        return Paciente::search("SELECT * FROM optica.paciente");
    }

    protected function store()
    {
        // TODO: Implement store() method.
    }
}