<?php

namespace Gestor\MaterialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * MaterialPolicial
 * @ORM\Entity(repositoryClass="Gestor\MaterialBundle\Entity\MaterialPolicialRepository")
 * @DoctrineAssert\UniqueEntity(fields="id", message="Ya existe un material policial con este ID")
 * 
 */
class MaterialPolicial
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
     * @ORM\ManyToOne(targetEntity="Gestor\GestionBundle\Entity\infoTipoPolicial")
     * @Assert\NotBlank(message = "Por favor, seleccione el tipo de material policial")
     */
    private $tipo;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=45, name="caracteristicas", nullable=true)
     *
     */
    private $talla;


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
     * @return MaterialInformatico
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
     * @return MaterialInformatico
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
     * @return MaterialInformatico
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
     * @return MaterialInformatico
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
     * @return MaterialInformatico
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
     * @return MaterialInformatico
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
     * @return MaterialInformatico
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
     * @return MaterialInformatico
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
     * @param Gestor\GestionBundle\Entity\ $infoTipoPolicial
     * @return MaterialPolicial
     */
    public function setTipo($infoTipoPolicial)
    {
        $this->tipo = $infoTipoPolicial;
    
        return $this;
    }

    /**
     * Get tipo
     *
    * @return Gestor\GestionBundle\Entity\infoTipoPolicial
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set talla
     *
     * @param string $caracteristicas
     * @return MaterialPolicial
     */
    public function setTalla($talla)
    {
        $this->talla = $talla;
    
        return $this;
    }

    /**
     * Get caracteristicas
     *
     * @return string 
     */
    public function getTalla()
    {
        return $this->talla;
    }
   
    public function asignarDatos($fkExp,$des,$tip,$mar,$mod,$tal,$nse,$dest,$can,$obs){
        $this->fkExpediente = $fkExp;
        $this->descripcion = $des;
        $this->tipo= $tip;
        $this->marca=$mar;
        $this->modelo=$mod;
        $this->talla=$tal;
        $this->numserie=$nse;
        $this->destino=$dest;
        $this->cantidad=$can;
        $this->observaciones=$obs;
    }
}

