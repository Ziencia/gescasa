<?php

namespace Gestor\UsuarioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Gestor\UsuarioBundle\Entity\Usuario;
/**
 * Fixtures de la entidad Usuario.
 * Crea 500 usuarios de prueba con información muy realista.
 */
class Usuarios extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    public function getOrder()
    {
        return 40;
    }

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager){
        
        
        
        //usuario:operador
            $usuario = new Usuario();
            $usuario->setNombre('Operador');
            $usuario->setApellidos('Operador');
            $usuario->setTIP('A11111A');
            $usuario->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));

            $encoder = $this->container->get('security.encoder_factory')->getEncoder($usuario);
            $passwordCodificado = $encoder->encodePassword('A11111A', $usuario->getSalt());
            $usuario->setPassword($passwordCodificado);

            $usuario->setFechaAlta(new \DateTime('now - '.rand(1, 150).' days'));            
            $usuario->setDni('1111111G');
            $usuario->setAutorizado(true);            
            $usuario->setRoles('ROLE_USER');

            $manager->persist($usuario);
         
            //usuario:gestor
            $usuario = new Usuario();
            $usuario->setNombre('Gestor');
            $usuario->setApellidos('Gestor');
            $usuario->setTIP('A22222A');
            $usuario->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));

            $passwordCodificado = $encoder->encodePassword('A22222A', $usuario->getSalt());
            $usuario->setPassword($passwordCodificado);

            $usuario->setFechaAlta(new \DateTime('now - '.rand(1, 150).' days'));            
            $usuario->setDni('2222222P');
            $usuario->setAutorizado(true);            
            $usuario->setRoles('ROLE_ADMIN');

            $manager->persist($usuario);
            
            //usuario:admin
            $usuario = new Usuario();
            $usuario->setNombre('Administrador');
            $usuario->setApellidos('Administrador');
            $usuario->setTIP('A33333A');
            $usuario->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));

            $passwordCodificado = $encoder->encodePassword('A33333A', $usuario->getSalt());
            $usuario->setPassword($passwordCodificado);

            $usuario->setFechaAlta(new \DateTime('now - '.rand(1, 150).' days'));            
            $usuario->setDni('3333333N');
            $usuario->setAutorizado(true);            
            $usuario->setRoles('ROLE_SUPER_ADMIN');

            $manager->persist($usuario);
            
        $dni = array('32988682N','80421365W','75708393Y','67130827Z','59477132Y','51639976P','06604101L','28076248X','40938342K','48657590D',
                     '09125417Y','24689694E','83661135S','77992655T','00794031W','49801241P','82443923D','36626824Z','94041543V','48156773V');

        for ($i=1; $i<=20; $i++) {
            $usuario = new Usuario();

            $usuario->setNombre($this->getNombre());
            $usuario->setApellidos($this->getApellidos());
            $usuario->setTIP($this->getTIP());

            $usuario->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));

            $passwordEnClaro = $usuario->getTIP();

            $passwordCodificado = $encoder->encodePassword($passwordEnClaro, $usuario->getSalt());
            $usuario->setPassword($passwordCodificado);

            $usuario->setFechaAlta(new \DateTime('now - '.rand(1, 150).' days'));
            
            $usuario->setDni($dni[$i-1]);
            
            // El 80% de los usuarios esta autorizado
            $usuario->setAutorizado((rand(1, 1000) % 10) < 8);
            
            $usuario->setRoles($this->getRoles());

            $manager->persist($usuario);
        }

        $manager->flush();
    }

    /**
     * Generador aleatorio de nombres de personas.
     * Aproximadamente genera un 50% de hombres y un 50% de mujeres.
     *
     * @return string Nombre aleatorio generado para el usuario.
     */
    private function getNombre()
    {
        // Los nombres más populares en España según el INE
        // Fuente: http://www.ine.es/daco/daco42/nombyapel/nombyapel.htm

        $hombres = array(
            'Antonio', 'José', 'Manuel', 'Francisco', 'Juan', 'David',
            'José Antonio', 'José Luis', 'Jesús', 'Javier', 'Francisco Javier',
            'Carlos', 'Daniel', 'Miguel', 'Rafael', 'Pedro', 'José Manuel',
            'Ángel', 'Alejandro', 'Miguel Ángel', 'José María', 'Fernando',
            'Luis', 'Sergio', 'Pablo', 'Jorge', 'Alberto'
        );
        $mujeres = array(
            'María Carmen', 'María', 'Carmen', 'Josefa', 'Isabel', 'Ana María',
            'María Dolores', 'María Pilar', 'María Teresa', 'Ana', 'Francisca',
            'Laura', 'Antonia', 'Dolores', 'María Angeles', 'Cristina', 'Marta',
            'María José', 'María Isabel', 'Pilar', 'María Luisa', 'Concepción',
            'Lucía', 'Mercedes', 'Manuela', 'Elena', 'Rosa María'
        );

        if (rand() % 2) {
            return $hombres[array_rand($hombres)];
        } else {
            return $mujeres[array_rand($mujeres)];
        }
    }

    /**
     * Generador aleatorio de apellidos de personas.
     *
     * @return string Apellido aleatorio generado para el usuario.
     */
    private function getApellidos()
    {
        // Los apellidos más populares en España según el INE
        // Fuente: http://www.ine.es/daco/daco42/nombyapel/nombyapel.htm

        $apellidos = array(
            'García', 'González', 'Rodríguez', 'Fernández', 'López', 'Martínez',
            'Sánchez', 'Pérez', 'Gómez', 'Martín', 'Jiménez', 'Ruiz',
            'Hernández', 'Díaz', 'Moreno', 'Álvarez', 'Muñoz', 'Romero',
            'Alonso', 'Gutiérrez', 'Navarro', 'Torres', 'Domínguez', 'Vázquez',
            'Ramos', 'Gil', 'Ramírez', 'Serrano', 'Blanco', 'Suárez', 'Molina',
            'Morales', 'Ortega', 'Delgado', 'Castro', 'Ortíz', 'Rubio', 'Marín',
            'Sanz', 'Iglesias', 'Nuñez', 'Medina', 'Garrido'
        );

        return $apellidos[array_rand($apellidos)].' '.$apellidos[array_rand($apellidos)];
    }

    /**
     * Generador aleatorio de direcciones postales.
     *
     * @param  Ciudad $ciudad Objeto de la ciudad para la que se genera una dirección postal.
     * @return string         Dirección postal aleatoria generada para la tienda.
     */
    private function getRoles()
    {
        $roles = array('ROLE_USER', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN');

        return $roles[array_rand($roles)];
    }
    
    private function getTIP(){
        $letra = array('B','C','D','F','G','H','I','J','K','L','M','N','P');
        
        return $letra[array_rand($letra)].rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9).$letra[array_rand($letra)];
    }
}

