<?php

namespace Gestor\MaterialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Material
 */
class Material
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $fkExpediente;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $marca;

    /**
     * @var string
     */
    private $modelo;

    /**
     * @var string
     */
    private $destino;

    /**
     * @var string
     */
    private $numSerie;

    /**
     * @var integer
     */
    private $cantidad;

    /**
     * @var integer
     */
    private $tipo;

    /**
     * @var string
     */
    private $observaciones;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fkExpediente
     *
     * @param integer $fkExpediente
     * @return Material
     */
    public function setFkExpediente($fkExpediente)
    {
        $this->fkExpediente = $fkExpediente;
    
        return $this;
    }

    /**
     * Get fkExpediente
     *
     * @return integer 
     */
    public function getFkExpediente()
    {
        return $this->fkExpediente;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Material
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set marca
     *
     * @param string $marca
     * @return Material
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
    
        return $this;
    }

    /**
     * Get marca
     *
     * @return string 
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set modelo
     *
     * @param string $modelo
     * @return Material
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    
        return $this;
    }

    /**
     * Get modelo
     *
     * @return string 
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set destino
     *
     * @param string $destino
     * @return Material
     */
    public function setDestino($destino)
    {
        $this->destino = $destino;
    
        return $this;
    }

    /**
     * Get destino
     *
     * @return string 
     */
    public function getDestino()
    {
        return $this->destino;
    }

    /**
     * Set numSerie
     *
     * @param string $numSerie
     * @return Material
     */
    public function setNumSerie($numSerie)
    {
        $this->numSerie = $numSerie;
    
        return $this;
    }

    /**
     * Get numSerie
     *
     * @return string 
     */
    public function getNumSerie()
    {
        return $this->numSerie;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return Material
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    
        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     * @return Material
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    
        return $this;
    }

    /**
     * Get tipo
     *
     * @return integer 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Material
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    
        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }
}
