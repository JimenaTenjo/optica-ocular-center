<?php
namespace App\Modelo;
require_once ('db_abstract_class.php');

class Persona extends db_abstract_class
{
    private $idPersona;
    private $nombres;
    private $apellidos;
    private $numero_documento;
    private $tipo_documento;
    private $ciudad;
    private $genero;
    private $email;
    private $telefono;
    private $rol;
    private $estado;
    private $direccion;
    private $fecha_nacimiento;
    private $contrasena;

    /* Relaciones */
    private $Medico;
    private $Paciente;

    /**
     * persona constructor.
     * @param $idPersona
     * @param $nombres
     * @param $apellidos
     * @param $numero_documento
     * @param $tipo_documento
     * @param $ciudad
     * @param $genero
     * @param $email
     * @param $telefono
     * @param $rol
     * @param $estado
     * @param $direccion
     * @param $fecha_nacimiento
     * @param $contrasena
     */
    public function __construct($Persona=array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->idPersona = $Persona ['idPersona'] ?? null;
        $this->nombres = $Persona ['nombres'] ?? null;
        $this->apellidos = $Persona ['apellidos'] ?? null;
        $this->numero_documento = $Persona ['numero_documento'] ?? null;
        $this->tipo_documento = $Persona ['tipo_documento'] ?? null;
        $this->ciudad = $Persona ['ciudad'] ?? null;
        $this->genero = $Persona ['genero'] ?? null;
        $this->email = $Persona ['email'] ?? null;
        $this->telefono = $Persona ['telefono'] ?? null;
        $this->rol = $Persona ['rol'] ?? null;
        $this->estado = $Persona ['estado'] ?? null;
        $this->direccion = $Persona ['direccion'] ?? null;
        $this->fecha_nacimiento = $Persona ['fecha_nacimiento'] ?? null;
        $this->contrasena = $Persona ['contrasena'] ?? null;
    }

    /**
     * @return mixed
     */
    public function getIdPersona()
    {
        return $this->idPersona;
    }

    /**
     * @param mixed $idPersona
     */
    public function setIdPersona($idPersona): void
    {
        $this->idPersona = $idPersona;
    }

    /**
     * @return mixed
     */
    public function getNombres()
    {
        return ucwords($this->nombres);
    }

    /**
     * @param mixed $nombres
     */
    public function setNombres($nombres): void
    {
        $this->nombres = strtolower($nombres);
    }

    /**
     * @return mixed
     */
    public function getApellidos()
    {
        return ucwords($this->apellidos);
    }

    /**
     * @param mixed $apellidos
     */
    public function setApellidos($apellidos): void
    {
        $this->apellidos = strtolower($apellidos);
    }

    /**
     * @return mixed
     */
    public function getNumeroDocumento()
    {
        return $this->numero_documento;
    }

    /**
     * @param mixed $numero_documento
     */
    public function setNumeroDocumento($numero_documento): void
    {
        $this->numero_documento = $numero_documento;
    }

    /**
     * @return mixed
     */
    public function getTipoDocumento()
    {
        return $this->tipo_documento;
    }

    /**
     * @param mixed $tipo_documento
     */
    public function setTipoDocumento($tipo_documento): void
    {
        $this->tipo_documento = $tipo_documento;
    }

    /**
     * @return mixed
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * @param mixed $ciudad
     */
    public function setCiudad($ciudad): void
    {
        $this->ciudad = $ciudad;
    }

    /**
     * @return mixed
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * @param mixed $genero
     */
    public function setGenero($genero): void
    {
        $this->genero = $genero;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * @param mixed $rol
     */
    public function setRol($rol): void
    {
        $this->rol = $rol;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado): void
    {
        $this->estado = $estado;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed
     */
    public function getFechaNacimiento()
    {
        return $this->fecha_nacimiento;
    }

    /**
     * @param mixed $fecha_nacimiento
     */
    public function setFechaNacimiento($fecha_nacimiento): void
    {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    /**
     * @return mixed
     */
    public function getContrasena()
    {
        return $this->contrasena;
    }

    /**
     * @param mixed $contrasena
     */
    public function setContrasena($contrasena): void
    {
        $this->contrasena = $contrasena;
    }

    public function getFullName()
    {
        return ucwords($this->nombres).' '.ucwords($this->apellidos);
    }
    public function getEdad()
    {
        return 25;
    }



    public function create()
    {
        $this->insertRow("INSERT INTO optica.persona VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
                $this->nombres,
                $this->apellidos,
                $this->numero_documento,
                $this->tipo_documento,
                $this->ciudad,
                $this->genero,
                $this->email,
                $this->telefono,
                $this->estado,
                $this->rol,
                $this->direccion,
                $this->fecha_nacimiento,
                password_hash($this->contrasena, PASSWORD_BCRYPT)
            )
        );

        $lastId = $this->getLastId();
        $this->Disconnect();
        return $lastId;
    }

    public function update()
    {
        $result = $this->updateRow("UPDATE optica.persona SET nombres = ?, apellidos = ?, numero_documento = ?, tipo_documento = ?, ciudad = ?, genero = ?, email = ?, telefono = ?, 
                estado = ?, rol = ?, direccion = ?, fecha_nacimiento = ?, contrasena = ? WHERE idPersona = ?", array(
                $this->nombres,
                $this->apellidos,
                $this->numero_documento,
                $this->tipo_documento,
                $this->ciudad,
                $this->genero,
                $this->email,
                $this->telefono,
                $this->estado,
                $this->rol,
                $this->direccion,
                $this->fecha_nacimiento,
                password_hash($this->contrasena, PASSWORD_BCRYPT),
                $this->idPersona
            )
        );
        $this->Disconnect();
        return $result;
    }

    public function deleted($idPersona)
    {
        // TODO: Implement deleted() method.
    }

    public static function search($query) : array
    {
        $ArrPersona = array();
        $tmp = new Persona();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $persona = new Persona();
            $persona->idPersona = $valor['idPersona'];
            $persona->nombres = $valor['nombres'];
            $persona->apellidos = $valor['apellidos'];
            $persona->numero_documento = $valor['numero_documento'];
            $persona->tipo_documento = $valor['tipo_documento'];
            $persona->ciudad = $valor['ciudad'];
            $persona->genero = $valor['genero'];
            $persona->email = $valor['email'];
            $persona->telefono = $valor['telefono'];
            $persona->estado = $valor['estado'];
            $persona->rol = $valor['rol'];
            $persona->direccion = $valor['direccion'];
            $persona->fecha_nacimiento = $valor['fecha_nacimiento'];
            $persona->contrasena = $valor['contrasena'];
            $persona->Disconnect();
            array_push($ArrPersona, $persona);
        }
        $tmp->Disconnect();
        return $ArrPersona;
    }

    public static function searchForId($idPersona)
    {
        $persona = new Persona();
        if ($idPersona > 0){
            $getrow = $persona->getRow("SELECT * FROM optica.persona WHERE idPersona =?", array($idPersona));
            $persona->idPersona = $getrow['idPersona'];
            $persona->nombres = $getrow['nombres'];
            $persona->apellidos = $getrow['apellidos'];
            $persona->numero_documento = $getrow['numero_documento'];
            $persona->tipo_documento = $getrow['tipo_documento'];
            $persona->ciudad = $getrow['ciudad'];
            $persona->genero = $getrow['genero'];
            $persona->email = $getrow['email'];
            $persona->telefono = $getrow['telefono'];
            $persona->estado = $getrow['estado'];
            $persona->rol = $getrow['rol'];
            $persona->direccion = $getrow['direccion'];
            $persona->fecha_nacimiento = $getrow['fecha_nacimiento'];
            $persona->contrasena = $getrow['contrasena'];
            $persona->Disconnect();
            return $persona;
        }else{
            $persona->Disconnect();
            unset($persona);
            return NULL;
        }
    }

    public static function getAll() : array
    {
        return Persona::search("SELECT * FROM optica.persona");
    }

    public static function personaregistrada ($numero_documento) : bool
    {
        $result = Persona::search("SELECT * FROM optica.persona where numero_documento = '".$numero_documento."'");
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }

    protected function store()
    {
        // TODO: Implement store() method.
    }
}