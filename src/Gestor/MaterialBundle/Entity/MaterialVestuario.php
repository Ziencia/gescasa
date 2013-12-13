<?php

namespace Gestor\MaterialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * MaterialVestuario
 * @ORM\Entity(repositoryClass="Gestor\MaterialBundle\Entity\MaterialVestuarioRepository")
 * @DoctrineAssert\UniqueEntity(fields="id", message="Ya existe un material automoción con este ID")
 * 
 */
class MaterialVestuario
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
     * @ORM\ManyToOne(targetEntity="Gestor\GestionBundle\Entity\infoTipoVestuario")
     * @Assert\NotBlank(message = "Por favor, seleccione el tipo de material de vestuario")
     */
    private $tipo;
        
    /**
     * @var string
     * @ORM\Column(type="string", length=20, name="tallla", nullable=true)
     *
     */
    private $talla;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=20, name="color", nullable=true)
     *
     */
    private $color;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=20, name="sexo", nullable=true)
     *
     */
    private $sexo;
    
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
     * @return MaterialVestuario
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
     * @return MaterialVestuario
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
     * @return MaterialVestuario
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
     * @return MaterialVestuario
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
     * @return MaterialVestuario
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
     * @return MaterialVestuario
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
     * @return MaterialVestuario
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
     * @return MaterialVestuario
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
     * @return MaterialVestuario
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
     * Set talla
     *
     * @param string $talla
     * @return MaterialVestuario
     */
    public function setTalla($talla)
    {
        $this->talla = $talla;
    
        return $this;
    }

    /**
     * Get talla
     *
     * @return string 
     */
    public function getTalla()
    {
        return $this->talla;
    }
    
    /**
     * Set sexo
     *
     * @param string $sexo
     * @return MaterialVestuario
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    
        return $this;
    }

    /**
     * Get sexo
     *
     * @return string 
     */
    public function getSexo()
    {
        return $this->sexo;
    }  
    
    
     /**
     * Set color
     *
     * @param string $color
     * @return MaterialVestuario
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
    
    
    
    public function asignarDatos($fkExp,$des,$tip,$mar,$mod,$nse,$dest,$can,$obs,$tal,$col,$sex){
        $this->fkExpediente = $fkExp;
        $this->descripcion = $des;
        $this->tipo= $tip;
        $this->marca=$mar;
        $this->modelo=$mod;
        $this->numserie=$nse;
        $this->destino=$dest;
        $this->cantidad=$can;
        $this->observaciones=$obs;
        $this->talla=$tal;
        $this->color=$col;
        $this->sexo=$sex;
    }
}
