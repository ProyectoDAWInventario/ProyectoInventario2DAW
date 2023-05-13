<!-- Clase que modeliza todas las propiedades del objeto material instituto -->
<?php

class MaterialInstituto {
    private $departamento;
    private $codigo;
    private $fechaAlta;
    private $isbn;
    private $nombre;
    private $descripcion;
    private $unidades;
    private $localizacion;
    private $procedencia;
    private $motivoBaja;
    private $fechaBaja;

    // Falta imagen.
    function __construct(){}

    /**
     * Get the value of departamento
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * Set the value of departamento
     */
    public function setDepartamento($departamento): self
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get the value of codigo
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set the value of codigo
     */
    public function setCodigo($codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get the value of fechaAlta
     */
    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }

    /**
     * Set the value of fechaAlta
     */
    public function setFechaAlta($fechaAlta): self
    {
        $this->fechaAlta = $fechaAlta;

        return $this;
    }

    /**
     * Get the value of isbn
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set the value of isbn
     */
    public function setIsbn($isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre($nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     */
    public function setDescripcion($descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of unidades
     */
    public function getUnidades()
    {
        return $this->unidades;
    }

    /**
     * Set the value of unidades
     */
    public function setUnidades($unidades): self
    {
        $this->unidades = $unidades;

        return $this;
    }

    /**
     * Get the value of localizacion
     */
    public function getLocalizacion()
    {
        return $this->localizacion;
    }

    /**
     * Set the value of localizacion
     */
    public function setLocalizacion($localizacion): self
    {
        $this->localizacion = $localizacion;

        return $this;
    }

    /**
     * Get the value of procedencia
     */
    public function getProcedencia()
    {
        return $this->procedencia;
    }

    /**
     * Set the value of procedencia
     */
    public function setProcedencia($procedencia): self
    {
        $this->procedencia = $procedencia;

        return $this;
    }

    /**
     * Get the value of motivoBaja
     */
    public function getMotivoBaja()
    {
        return $this->motivoBaja;
    }

    /**
     * Set the value of motivoBaja
     */
    public function setMotivoBaja($motivoBaja): self
    {
        $this->motivoBaja = $motivoBaja;

        return $this;
    }

    /**
     * Get the value of fechaBaja
     */
    public function getFechaBaja()
    {
        return $this->fechaBaja;
    }

    /**
     * Set the value of fechaBaja
     */
    public function setFechaBaja($fechaBaja): self
    {
        $this->fechaBaja = $fechaBaja;

        return $this;
    }
}
?>