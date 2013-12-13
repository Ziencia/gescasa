<?php

namespace Gestor\MaterialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * MaterialAutomocion
 * @ORM\Entity(repositoryClass="Gestor\MaterialBundle\Entity\MaterialAutomocionRepository")
 * @DoctrineAssert\UniqueEntity(fields="id", message="Ya existe un material automoción con este ID")
 * 
 */
class MaterialAutomocion
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
     * @ORM\ManyToOne(targetEntity="Gestor\GestionBundle\Entity\infoTipoAutomocion")
     * @Assert\NotBlank(message = "Por favor, seleccione el tipo de material automoción")
     */
    private $tipo;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=150, name="bastidor", nullable=true)
     *
     */
    private $bastidor;

    /**
     * @var string
     * @ORM\Column(type="string", length=150, name="concesionario", nullable=true)
     *
     */
    private $concesionario;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, name="kit", nullable=true)
     *
     */
    private $kit;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=50, name="motor", nullable=true)
     *
     */
    private $motor;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=20, name="color", nullable=true)
     *
     */
    private $color;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=20, name="matricula", nullable=true)
     *
     */
    private $matricula;
    
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
     * @return MaterialAutomocion
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
     * @return MaterialAutomocion
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
     * @return MaterialAutomocion
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
     * @return MaterialAutomocion
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
     * @return MaterialAutomocion
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
     * @return MaterialAutomocion
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
     * @return MaterialAutomocion
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
     * @return MaterialAutomocion
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
     * @return MaterialAutomocion
     */
    public function setTipo($infoTipoMobiliario)
    {
        $this->tipo = $infoTipoMobiliario;
    
        return $this;
    }

    /**
     * Get tipo
     *
    * @return Gestor\GestionBundle\Entity\infoTipoAutomocion
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set bastidor
     *
     * @param string $bastidor
     * @return MaterialAutomocion
     */
    public function setBastidor($bastidor)
    {
        $this->bastidor = $bastidor;
    
        return $this;
    }

    /**
     * Get bastidor
     *
     * @return string 
     */
    public function getBastidor()
    {
        return $this->bastidor;
    }

    /**
     * Set concesionario
     *
     * @param string $concesionario
     * @return MaterialAutomocion
     */
    public function setConcesionario($concesionario)
    {
        $this->concesionario = $concesionario;
    
        return $this;
    }

    /**
     * Get concesionario
     *
     * @return string 
     */
    public function getConcesionario()
    {
        return $this->concesionario;
    }
    
    /**
     * Set kit
     *
     * @param string $kit
     * @return MaterialAutomocion
     */
    public function setKit($kit)
    {
        $this->kit = $kit;
    
        return $this;
    }

    /**
     * Get kit
     *
     * @return string 
     */
    public function getKit()
    {
        return $this->kit;
    }  
    
    /**
     * Set motor
     *
     * @param string $motor
     * @return MaterialAutomocion
     */
    public function setMotor($motor)
    {
        $this->motor = $motor;
    
        return $this;
    }

    /**
     * Get motor
     *
     * @return string 
     */
    public function getMotor()
    {
        return $this->motor;
    }  
    
     /**
     * Set color
     *
     * @param string $color
     * @return MaterialAutomocion
     */
    public function setColor($color)
    {
        $this->color = $color;
    
        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }  
    
    /**
     * Set matricula
     *
     * @param string $matricula
     * @return MaterialAutomocion
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;
    
        return $this;
    }

    /**
     * Get matricula
     *
     * @return string 
     */
    public function getMatricula()
    {
        return $this->matricula;
    } 
    
    
    
    public function asignarDatos($fkExp,$des,$tip,$mar,$mod,$nse,$dest,$can,$obs,$bas,$con,$kit,$mot,$col,$mat){
        $this->fkExpediente = $fkExp;
        $this->descripcion = $des;
        $this->tipo= $tip;
        $this->marca=$mar;
        $this->modelo=$mod;
        $this->numserie=$nse;
        $this->destino=$dest;
        $this->cantidad=$can;
        $this->observaciones=$obs;
        $this->bastidor=$bas;
        $this->concesionario=$con;
        $this->kit=$kit;
        $this->moto=$mot;
        $this->color=$col;
        $this->matricula=$mat;
    }
}
