<?php

namespace Gestor\MaterialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * MaterialMobiliario
 * @ORM\Entity(repositoryClass="Gestor\MaterialBundle\Entity\MaterialMobiliarioRepository")
 * @DoctrineAssert\UniqueEntity(fields="id", message="Ya existe un material mobiliario con este ID")
 * 
 */
class MaterialMobiliario
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var $expediente
     * 
     * @ORM\ManyToOne(targetEntity="Gestor\ExpedientesBundle\Entity\Expediente")
     * @ORM\JoinColumn(name="expediente_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\Type("Gestor\ExpedientesBundle\Entity\Expediente")
     */
    private $fkExpediente;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255, name="descripcion", nullable=true)
     */
    private $descripcion;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255, name="marca")
     */
    private $marca;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255, name="modelo")
     */
    private $modelo;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, name="destino", nullable=true)
     */
    private $destino;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=40, name="numserie", nullable=true)
     */
    private $numserie;
    
     /**
     * @var integer
     * @ORM\Column(type="integer", name="cantidad", nullable=true)
     */
    private $cantidad;   
  
    /**
     * @var string
     * @ORM\Column(type="string", length=255, name="observaciones", nullable=true)
     */
    private $observaciones;
 
    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="Gestor\GestionBundle\Entity\infoTipoMobiliario")
     * @Assert\NotBlank(message = "Por favor, seleccione el tipo de material mobiliario")
     */
    private $tipo;
    
    /**
     * @var decimal
     * @ORM\Column(type="decimal", precision=5, scale=2, name="largo", nullable=true)
     *
     */
    private $largo;

    /**
     * @var decimal
     * @ORM\Column(type="decimal", precision=5, scale=2, name="ancho", nullable=true)
     *
     */
    private $ancho;

     /**
     * @var decimal
     * @ORM\Column(type="decimal", precision=5, scale=2, name="alto", nullable=true)
     *
     */
    private $alto;
    
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
     * @param Gestor\GestionBundle\Entity\ $expediente
     * @return MaterialMobiliario
     */
    public function setfkExpediente($expediente)
    {
        $this->fkExpediente = $expediente;
    
        return $this;
    }

    /**
     * Get fkExpediente
     *
     * @return Gestor\GestionBundle\Entity\Expediente
     */
    public function getfkExpediente()
    {
        return $this->fkExpediente;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return MaterialMobiliario
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
     * @return MaterialMobiliario
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
     * @return MaterialMobiliario
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
     * @return MaterialMobiliario
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
     * Set numserie
     *
     * @param string $numserie
     * @return MaterialMobiliario
     */
    public function setNumSerie($numserie)
    {
        $this->numserie = $numserie;
    
        return $this;
    }

    /**
     * Get numserie
     *
     * @return string 
     */
    public function getNumSerie()
    {
        return $this->numserie;
    }
 
    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return MaterialMobiliario
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
     * Set observaciones
     *
     * @param string $observaciones
     * @return MaterialMobiliario
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
   
    /**
     * Set tipo
     *
     * @param Gestor\GestionBundle\Entity\ $infoTipoMobiliario
     * @return MaterialMobiliario
     */
    public function setTipo($infoTipoMobiliario)
    {
        $this->tipo = $infoTipoMobiliario;
    
        return $this;
    }

    /**
     * Get tipo
     *
    * @return Gestor\GestionBundle\Entity\infoTipoMobiliario
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set largo
     *
     * @param decimal $largo
     * @return MaterialMobiliario
     */
    public function setLargo($largo)
    {
        $this->largo = $largo;
    
        return $this;
    }

    /**
     * Get largo
     *
     * @return decimal 
     */
    public function getLargo()
    {
        return $this->largo;
    }

    /**
     * Set ancho
     *
     * @param decimal $ancho
     * @return MaterialMobiliario
     */
    public function setAncho($ancho)
    {
        $this->ancho = $ancho;
    
        return $this;
    }

    /**
     * Get ancho
     *
     * @return decimal 
     */
    public function getAncho()
    {
        return $this->ancho;
    }
    /**
     * Set alto
     *
     * @param decimal $alto
     * @return MaterialMobiliario
     */
    public function setAlto($alto)
    {
        $this->alto = $alto;
    
        return $this;
    }

    /**
     * Get alto
     *
     * @return decimal 
     */
    public function getAlto()
    {
        return $this->alto;
    }    
    
    public function asignarDatos($fkExp,$des,$tip,$mar,$mod,$nse,$dest,$can,$obs,$lar,$anc,$alt){
        $this->fkExpediente = $fkExp;
        $this->descripcion = $des;
        $this->tipo= $tip;
        $this->marca=$mar;
        $this->modelo=$mod;
        $this->numserie=$nse;
        $this->destino=$dest;
        $this->cantidad=$can;
        $this->observaciones=$obs;
        $this->largo=$lar;
        $this->ancho=$anc;
        $this->alto=$alt;
    }
}
