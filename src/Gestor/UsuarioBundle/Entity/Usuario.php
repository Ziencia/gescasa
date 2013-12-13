<?php

namespace Gestor\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Usuario
 *
 * 
 * @ORM\Entity(repositoryClass="Gestor\UsuarioBundle\Entity\UsuarioRepository")
 * @DoctrineAssert\UniqueEntity(fields="tip", message="El TIP especificado ya existe")
 * @DoctrineAssert\UniqueEntity(fields="dni", message="El DNI especificado ya existe")
 * @Assert\Callback(methods={"esDniValido"})
 * @Assert\Callback(methods={"esTipValido"})
 * 
 */
class Usuario implements AdvancedUserInterface {

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
     * @ORM\Column(type="string", length=100, nullable=true, name="nombre")
     * @Assert\NotBlank(message = "Por favor, escribe el nombre")
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=200, nullable=true, name="apellidos")
     * @Assert\NotBlank(message = "Por favor, escribe los apellidos")
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, length=7, nullable=true, name="tip")
     * @Assert\Length(min=7, minMessage = "El TIP deberia tener 7 caracteres para considerarlo valido")
     * @Assert\Length(max=7, maxMessage = "El TIP deberia tener 7 caracteres para considerarlo valido")
     */
    private $tip;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true, name="password")
     * @Assert\NotBlank(message = "Por favor, escribe el password")
     * @Assert\Length(min=6, minMessage="El password debe tener una longitud minima de 6 caracteres")
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true, name="salt")
     */
    private $salt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true, name="fecha_alta")
     */
    private $fechaAlta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true, name="fecha_baja")
     */
    private $fechaBaja;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, length=9, nullable=true, name="dni")
     * @Assert\NotBlank(message = "Por favor, escribe el dni")
     */
    private $dni;

    /**
     * @var boolean
     * 
     * @ORM\Column(type="boolean", nullable=true, name="autorizado")
     */
    private $autorizado;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20, nullable=true, name="roles")
     * @Assert\NotBlank(message = "Por favor, selecciona un rol")
     */
    private $roles;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Usuario
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     * @return Usuario
     */
    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos() {
        return $this->apellidos;
    }

    /**
     * Set tip
     *
     * @param string $tip
     * @return Usuario
     */
    public function setTip($tip) {
        $this->tip = $tip;

        return $this;
    }

    /**
     * Get tip
     *
     * @return string 
     */
    public function getTip() {
        return $this->tip;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Usuario
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Usuario
     */
    public function setSalt($salt) {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * Set fechaAlta
     *
     * @param \DateTime $fechaAlta
     * @return Usuario
     */
    public function setFechaAlta($fechaAlta) {
        $this->fechaAlta = $fechaAlta;

        return $this;
    }

    /**
     * Get fechaAlta
     *
     * @return \DateTime 
     */
    public function getFechaAlta() {
        return $this->fechaAlta;
    }

    /**
     * Set fechaBaja
     *
     * @param \DateTime $fechaBaja
     * @return Usuario
     */
    public function setFechaBaja($fechaBaja) {
        $this->fechaBaja = $fechaBaja;

        return $this;
    }

    /**
     * Get fechaBaja
     *
     * @return \DateTime 
     */
    public function getFechaBaja() {
        return $this->fechaBaja;
    }

    /**
     * Set dni
     *
     * @param string $dni
     * @return Usuario
     */
    public function setDni($dni) {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string 
     */
    public function getDni() {
        return $this->dni;
    }

    public function getAutorizado() {
        return $this->autorizado;
    }

    public function setAutorizado($autorizado) {
        $this->autorizado = $autorizado;
    }

    public function setRoles($rol) {
        $this->roles = $rol;
    }

    function eraseCredentials() {
        
    }

    function getRoles() {
        return array($this->roles);
    }

    function getUsername() {
        return $this->getTip();
    }
    
     public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->autorizado;
    }

    public function esDniValido(ExecutionContextInterface $context){
        
        $dni = $this->getDni();
            
        // Comprobar que el formato sea correcto
        if (0 === preg_match("/\d{1,8}[a-z]/i", $dni)) {
            $context->addViolationAt('dni', 'El DNI introducido no tiene el formato correcto (entre 1 y 8 números seguidos de una letra, sin guiones y sin dejar ningún espacio en blanco)', array(), null);
            return;
        }
        
        // Comprobar que la letra cumple con el algoritmo
        $numero = substr($dni, 0, -1);
        $letra = strtoupper(substr($dni, -1));
        if ($letra != substr("TRWAGMYFPDXBNJZSQVHLCKE", strtr($numero, "XYZ", "012") % 23, 1)) {  
                $context->addViolationAt('dni', 'La letra no coincide con el número del DNI. Comprueba que has escrito bien tanto el número como la letra', array(), null);
        }
    }
    
    public function esTipValido(ExecutionContextInterface $context){
        
        $tip = $this->getTip();
            
        // Comprobar que el formato sea correcto
        if (0 === preg_match("/[a-z]\d{5}[a-z]/i", $tip)) {
            $context->addViolationAt('tip', 'El TIP introducido no tiene el formato correcto ( letra, 5 digitos, letra), ej. A12345B', array(), null);
            return;
        }
    }

}
