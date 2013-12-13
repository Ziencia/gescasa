<?php

namespace Gestor\MensajeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mensaje
 * 
 * @ORM\Entity(repositoryClass="Gestor\MensajeBundle\Entity\MensajeRepository")
 * 
 */
class Mensaje
{
    
    public function __construct($usuario,$fecha,$mensaje){
        $this->setFecha($fecha);
        $this->setFkusuario($usuario);
        $this->setMensaje($mensaje);       
        
    }
    /**
     * @var integer
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id
     */
    private $id;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="gestor\UsuarioBundle\Entity\Usuario") 
     */
    private $fkusuario;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true, name="mensaje")     * 
     */
    private $mensaje;


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
     * Set fkusuario
     *
     * @param integer $fkusuario
     * @return Mensaje
     */
    public function setFkusuario($fkusuario)
    {
        $this->fkusuario = $fkusuario;
    
        return $this;
    }

    /**
     * Get fkusuario
     *
     * @return integer 
     */
    public function getFkusuario()
    {
        return $this->fkusuario;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Mensaje
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    
        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set mensaje
     *
     * @param string $mensaje
     * @return Mensaje
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    
        return $this;
    }

    /**
     * Get mensaje
     *
     * @return string 
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }
    
    public function grabarMensaje(){
        $em = $this->getDoctrine()->getManager();
        $em->persist($this);
        
        $em->flush();
    }
}
