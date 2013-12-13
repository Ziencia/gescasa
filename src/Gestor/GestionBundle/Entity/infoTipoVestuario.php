<?php

namespace Gestor\GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * infoTipoVestuario
 * 
 * @ORM\Table(name="infoTipoVestuario")
 * @ORM\Entity
 * @DoctrineAssert\UniqueEntity(fields="descripcion", message="Ya se ha definido un tipo de vestuario de este tipo para los materiales") 
 */
class infoTipoVestuario
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
     * @ORM\Column(type="string", length=255, nullable=false, name="descripcion")
     * @Assert\NotBlank(message = "Por favor, escribe una descripción")
     */
    private $descripcion;


    /**
     * Get id
     *
     * @return integer 
     * 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * 
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
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
    
        public function __toString()
    {
        return $this->getDescripcion();
    }
}
