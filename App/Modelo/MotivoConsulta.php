<?php
namespace App\Modelo;
require_once ('db_abstract_class.php');

class MotivoConsulta extends db_abstract_class
{
    private $idMotivoConsulta;
    private $descripcion;
    private $estado;

    /**
     * persona constructor.
     * @param $idMotivoConsulta
     * @param $descripcion
     * @param $estado
     */
    public function __construct($motivoConsulta=array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->idMotivoConsulta = $motivoConsulta ['idMotivoConsulta'] ?? null;
        $this->descripcion = $motivoConsulta ['descripcion'] ?? null;
        $this->estado = $motivoConsulta ['estado'] ?? null;
    }

    /**
     * @return mixed|null
     */
    public function getIdMotivoConsulta()
    {
        return $this->idMotivoConsulta;
    }

    /**
     * @param mixed|null $idMotivoConsulta
     */
    public function setIdMotivoConsulta( $idMotivoConsulta): void
    {
        $this->idMotivoConsulta = $idMotivoConsulta;
    }

    /**
     * @return mixed|null
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed|null $descripcion
     */
    public function setDescripcion( $descripcion): void
    {
        $this->descripcion = $descripcion;
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
        $ArrMotivoConsulta = array();
        $tmp = new MotivoConsulta();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $motivoConsulta = new MotivoConsulta();
            $motivoConsulta->idMotivoConsulta = $valor['idMotivoConsulta'];
            $motivoConsulta->descripcion = $valor['descripcion'];
            $motivoConsulta->estado = $valor['estado'];
            $motivoConsulta->Disconnect();
            array_push($ArrMotivoConsulta, $motivoConsulta);
        }
        $tmp->Disconnect();
        return $ArrMotivoConsulta;
    }

    public static function getAll()
    {
        return MotivoConsulta::search("SELECT * FROM optica.motivos_consulta");
    }

    public static function searchForId($idMotivoConsulta)
    {
        $motivoConsulta = new MotivoConsulta();
        if ($idMotivoConsulta > 0){
            $getrow = $motivoConsulta->getRow("SELECT * FROM optica.motivos_consulta WHERE idMotivoConsulta =?", array($idMotivoConsulta));
            $motivoConsulta->idMotivoConsulta = $getrow['idMotivoConsulta'];
            $motivoConsulta->descripcion = $getrow['descripcion'];
            $motivoConsulta->estado = $getrow['estado'];
            $motivoConsulta->Disconnect();
            return $motivoConsulta;
        }else{
            $motivoConsulta->Disconnect();
            unset($motivoConsulta);
            return NULL;
        }
    }

    public function create()
    {
        $this->insertRow("INSERT INTO optica.motivos_consulta VALUES (NULL, ?, ?)", array(
                $this->descripcion,
                $this->estado,
            )
        );
        $this->Disconnect();
    }

    public function update()
    {
        $this->updateRow("UPDATE optica.motivos_consulta SET descripcion = ?, estado = ?  WHERE idMotivoConsulta = ?", array(
                $this->descripcion,
                $this->estado,
                $this->idMotivoConsulta
            )
        );
        $this->Disconnect();
    }

    public function deleted($id)
    {
        // TODO: Implement deleted() method.
    }
}