<?php

namespace Gestor\ExpedientesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Expediente
 * @ORM\Entity(repositoryClass="Gestor\ExpedientesBundle\Entity\ExpedienteRepository")
 * @DoctrineAssert\UniqueEntity(fields="referencia", message="Ya existe un expediente con esta referencia")
 * @Assert\Callback(methods={"esRefValido"})
 */
class Expediente
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
     * @var string
     *
     * @ORM\Column(type="string", length=200, name="nombre")
     * @Assert\NotBlank(message = "Por favor, escribe el titulo del expediente")
     */
    private $titulo;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=45, name="referencia", unique=true)
     * @Assert\NotBlank(message = "Por favor, escribe el número de referencia del expediente")
     */
    private $referencia;
    
     /**
     * @var integer $infoTipoEstadoExpediente
     * 
     * @ORM\ManyToOne(targetEntity="Gestor\GestionBundle\Entity\infoTipoEstadoExpediente")
     * @Assert\NotBlank(message = "Por favor, seleccione el estado del expediente")
     * @Assert\Type("Gestor\GestionBundle\Entity\infoTipoEstadoExpediente")
     */
    private $estado;

    /**
     * @var integer $infoTipoEmpresa
     * 
     * @ORM\ManyToOne(targetEntity="Gestor\GestionBundle\Entity\infoTipoEmpresa")
     * @Assert\NotBlank(message = "Por favor, seleccione la empresa del expediente")
     * @Assert\Type("Gestor\GestionBundle\Entity\infoTipoEmpresa")
     */
    private $empresa;
    
    /**
     * @var integer $infoTipoAdjudicatario
     *
     * @ORM\ManyToOne(targetEntity="Gestor\GestionBundle\Entity\infoTipoAdjudicatario")
     * @Assert\NotBlank(message = "Por favor, seleccione el adjudicatario del expediente ")
     * @Assert\Type("Gestor\GestionBundle\Entity\infoTipoAdjudicatario")
     */
    private $adjudicatario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="fechaInicio")
     * @Assert\NotBlank(message = "Por favor, indique la fecha de inicio del expediente")
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="fechaFin", nullable=true)
     * 
     */
    private $fechaFin;

    
    /**
     * @var decimal
     *
     * @ORM\Column(type="decimal", precision=12, scale=3, name="importe", nullable=true)
     * 
     */
    private $importe;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, name="descripcion0", nullable=true)
     * 
     */
    private $descripcion0;
    
        /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, name="descripcion1", nullable=true)
     * 
     */
    private $descripcion1;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, name="descripcion2", nullable=true)
     * 
     */
    private $descripcion2;
    
    public function __construct(){
        
    }
    
    public function asignarDatos($titulo,$referencia,$estado,$empresa,$adjudicatario,$fInicio,$fFin,$importe,$desc0,$desc1,$desc2){
       $this->titulo=$titulo;
       $this->referencia=$referencia;
       $this->estado=$estado;
       $this->empresa=$empresa;
       $this->adjudicatario=$adjudicatario;
       $this->fechaInicio=$fInicio;
       $this->fechaFin=$fFin;
       $this->importe=$importe;
       $this->descripcion0=$desc0;
       $this->descripcion1=$desc1;  
       $this->descripcion2=$desc2;
    }
    
    public function __toString() {
        return $this->getReferencia();
    }
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
     * Set nombre
     *
     * @param string $titulo
     * 
     * @return Expediente
     */
    public function setTitulo($titulo) {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo() {
        return $this->titulo;
    }

    /**
     * Set referencia
     *
     * @param string $referencia
     * 
     * @return Expediente
     */
    public function setReferencia($referencia) {
        $this->referencia = $referencia;

        return $this;
    }

    /**
     * Get referencia
     *
     * @return string 
     */
    public function getReferencia() {
        return $this->referencia;
    }
    
    /**
     * Set estado
     *
     * @param Gestor\GestionBundle\Entity\ $infoTipoEstadoExpediente
     * 
     */
    public function setEstado($infoTipoEstadoExpediente) {
        $this->estado = $infoTipoEstadoExpediente;
    }
    
    /**
     * Get estado
     *
     * @return Gestor\GestionBundle\Entity\infoTipoEstadoExpediente 
     */
    public function getEstado() {
        return $this->estado;
    }   
    
    /**
     * Set empresa
     *
     * @param Gestor\GestionBundle\Entity\ $infoTipoEmpresa
     * 
     */    
    public function setEmpresa($infoTipoEmpresa) {
        $this->empresa = $infoTipoEmpresa;
    }
    
    /**
     * Get empresa
     *
     * @return Gestor\GestionBundle\Entity\infoTipoEmpresa
     */
    public function getEmpresa() {
        return $this->empresa;
    }
  
    /**
     * Set adjudicatario
     *
     * @param Gestor\GestionBundle\Entity\ $infoTipoAdjudicatario
     * 
     */    
    public function setAdjudicatario($infoTipoAdjudicatario) {
        $this->adjudicatario = $infoTipoAdjudicatario;
    }
    
    /**
     * Get adjudicatario
     *
     * @return Gestor\GestionBundle\Entity\infoTipoEmpresa
     */
    public function getAdjudicatario() {
        return $this->adjudicatario;
    }


        /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     * @return Expediente
     */
    public function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime 
     */
    public function getFechaInicio() {
        return $this->fechaInicio;
    }
    
    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     * @return Expediente
     */
    public function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return \DateTime 
     */
    public function getFechaFin() {
        return $this->fechaFin;
    }
    
    /**
     * Set importe
     *
     * @param decimal $importe
     * @return Expediente
     */
    public function setImporte($importe) {
        $this->importe = $importe;
        
        return $this;
    }
    
    /**
     * Get importe
     *
     * @return decimal 
     */    
    public function getImporte() {
        return $this->importe;
    }
    
     /**
     * Set descripcion0
     *
     * @param string $descripcion0
     * @return Expediente
     */
    public function setDescripcion0($descripcion0) {
        $this->descripcion0 = $descripcion0;

        return $this;
    }

    /**
     * Get descripcion0
     *
     * @return string 
     */
    public function getDescripcion0() {
        return $this->descripcion0;
    }
    
      /**
     * Set descripcion1
     *
     * @param string $descripcion1
     * @return Expediente
     */
    public function setDescripcion1($descripcion1) {
        $this->descripcion1 = $descripcion1;

        return $this;
    }

    /**
     * Get descripcion1
     *
     * @return string 
     */
    public function getDescripcion1() {
        return $this->descripcion1;
    }
    
     /**
     * Set descripcion2
     *
     * @param string $descripcion2
     *
     * @return Expediente
     */
    public function setDescripcion2($descripcion2) {
        $this->descripcion2 = $descripcion2;

        return $this;
    }

    /**
     * Get descripcion2
     *
     * @return string 
     */
    public function getDescripcion2() {
        return $this->descripcion2;
    }
    
    public function esRefValido(ExecutionContextInterface $context){
        
        $ref = $this->getReferencia();
            
        // Comprobar que el formato sea correcto
        if (0 === preg_match("/\d{4}\/\d{3}/i", $ref)) {
            $context->addViolationAt('referencia', 'El número de expediente introducido no tiene el formato correcto ( 4 dígitos, barra, 3 dígitos), ej. 2013/001', array(), null);
            return;
     }
   }

}

