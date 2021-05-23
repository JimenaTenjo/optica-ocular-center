<?php
namespace App\Modelo;
require_once ('db_abstract_class.php');
require_once ('Persona.php');
use App\Modelo\Persona;

class Medico extends db_abstract_class
{
    private $idMedico;
    private $especializacion;
    private $licencia;
    private $persona_medico;

    /**
     * persona constructor.
     * @param $idMedico
     * @param $especializacion
     * @param $licencia
     * @param $persona_medico
     */
    public function __construct($Medico=array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->idMedico = $Medico ['idMedico'] ?? null;
        $this->especializacion = $Medico ['especializacion'] ?? null;
        $this->licencia = $Medico ['licencia'] ?? null;
        $this->persona_medico = $Medico ['persona_medico'] ?? null;
        if ($this->persona_medico!=null){
            $this->persona_medico = Persona::searchForId($this->persona_medico);
        }
    }

    /**
     * @return mixed
     */
    public function getIdMedico()
    {
        return $this->idMedico;
    }

    /**
     * @param mixed|null $idMedico
     */
    public function setIdMedico($idMedico): void
    {
        $this->idMedico = $idMedico;
    }

    /**
     * @return mixed|null
     */
    public function getEspecializacion()
    {
        return $this->especializacion;
    }

    /**
     * @param mixed|null $especializacion
     */
    public function setEspecializacion( $especializacion): void
    {
        $this->especializacion = $especializacion;
    }

    /**
     * @return mixed|null
     */
    public function getLicencia()
    {
        return $this->licencia;
    }

    /**
     * @param mixed|null $licencia
     */
    public function setLicencia( $licencia): void
    {
        $this->licencia = $licencia;
    }

    /**
     * @return \App\Modelo\Persona|null
     */
    public function getPersonaMedico(): ?\App\Modelo\Persona
    {
        return $this->persona_medico;
    }

    /**
     * @param \App\Modelo\Persona|null $persona_medico
     */
    public function setPersonaMedico(?\App\Modelo\Persona $persona_medico): void
    {
        $this->persona_medico = $persona_medico;
    }



    public function create()
    {
        $this->insertRow("INSERT INTO optica.medico VALUES (NULL, ?, ?, ?)", array(
                $this->especializacion,
                $this->licencia,
                $this->persona_medico->getIdPersona()
            )
        );
        $this->Disconnect();
    }

    public function update()
    {
        $this->updateRow("UPDATE optica.paciente SET especializacion = ?, licencia = ?, persona_medico = ?,  WHERE idMedico = ?", array(
                $this->especializacion,
                $this->licencia,
                $this->persona_medico->getIdPersona(),
                $this->idMedico
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
        $ArrMedico = array();
        $tmp = new Medico();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $medico = new Medico();
            $medico->idMedico = $valor['idMedico'];
            $medico->especializacion = $valor['especializacion'];
            $medico->licencia = $valor['licencia'];
            $medico->persona_medico = Persona::searchForId($valor['persona_medico']);
            $medico->Disconnect();
            array_push($ArrMedico, $medico);
        }
        $tmp->Disconnect();
        return $ArrMedico;
    }

    public static function searchForId($idMedico)
    {
        $medico = new Medico();
        if ($idMedico > 0){
            $getrow = $medico->getRow("SELECT * FROM optica.medico WHERE idMedico =?", array($idMedico));
            $medico->idMedico = $getrow['idMedico'];
            $medico->especializacion = $getrow['especializacion'];
            $medico->licencia = $getrow['licencia'];
            $medico->persona_medico = Persona::searchForId($getrow['persona_medico']);
            $medico->Disconnect();
            return $medico;
        }else{
            $medico->Disconnect();
            unset($medico);
            return NULL;
        }
    }

    public static function getAll() : array
    {
        return Medico::search("SELECT * FROM optica.medico");
    }

    protected function store()
    {
        // TODO: Implement store() method.
    }
}