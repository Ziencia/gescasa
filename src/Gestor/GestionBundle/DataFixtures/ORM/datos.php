<?php

namespace Gestor\GestionBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Gestor\GestionBundle\Entity\infoTipoEstadoExpediente;
use Gestor\GestionBundle\Entity\infoTipoAdjudicatario;
use Gestor\GestionBundle\Entity\infoTipoEmpresa;
use Gestor\GestionBundle\Entity\infoTipoInformatica;
use Gestor\GestionBundle\Entity\infoTipoPolicial;
use Gestor\GestionBundle\Entity\infoTipoAutomocion;
use Gestor\GestionBundle\Entity\infoTipoMobiliario;
use Gestor\GestionBundle\Entity\infoTipoVestuario;
use Gestor\ExpedientesBundle\Entity\Expediente;
use Gestor\MaterialBundle\Entity\MaterialInformatico;
use Gestor\MaterialBundle\Entity\MaterialPolicial;

/**
 * Fixtures de DATOS.
 * 
 */
class Datos extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        
        $estados = array('Recibido','Tramitado','Otro');
        
        foreach ($estados as $descripcion){
            $entity = new infoTipoEstadoExpediente();            
            $entity->setDescripcion($descripcion);
            $manager->persist($entity);
        }
        
        $empresas = array('El Corte Inglés','Movistar','Textiles S.A.','Industrias Tecnológicas La Paz','Otras');
        
        foreach ($empresas as $descripcion){
            $entity = new infoTipoEmpresa();            
            $entity->setDescripcion($descripcion);
            $manager->persist($entity);
        }
        
        $adjudicatario = array('Secretaria general', 'Secretaria técnica', 'Departamento de RR.HH.','Laboratorio de informática', 'Otros');
        
        foreach ($adjudicatario as $descripcion){
            $entity = new infoTipoAdjudicatario();            
            $entity->setDescripcion($descripcion);
            $manager->persist($entity);
        }
        
        $informatica = array('Sobremesa','Portátil','Monitor','Impresora','Escaner','CPU','Disco duro','RAM','Router','Switch','Rack','Otros');
        
        foreach ($informatica as $descripcion){
            $entity = new infoTipoInformatica();            
            $entity->setDescripcion($descripcion);
            $manager->persist($entity);
        }
        
        $policial = array('Defensa rígida','Defensa extensible','Chaleco reflectante serigrafiado','Grillete semirigido','Arma corta','Arma larga','Comunicador','Funda arma corta','Otros');
        
        foreach ($policial as $descripcion){
            $entity = new infoTipoPolicial();            
            $entity->setDescripcion($descripcion);
            $manager->persist($entity);
        }
        
        $automocion = array('Coche','Furgoneta','Monovolumen','Moto','Todo terreno','Autocar', 'Camión', 'Otros');
        
        foreach ($automocion as $descripcion){
            $entity = new infoTipoAutomocion();       
            $entity->setDescripcion($descripcion);             
            $manager->persist($entity);
        }
        
        $mobiliario = array('Mesa','Mesa auxiliar','Escritorio','Silla','Lámpara','Estanteria', 'Reposapies', 'Cajonera', 'Esquinera', 'Otros');
        
        foreach ($mobiliario as $descripcion){
            $entity = new infoTipoMobiliario();       
            $entity->setDescripcion($descripcion);             
            $manager->persist($entity);
        }
        
        $vestuario = array('Camisa','Camisa térmica','Pantalón de invierno','Pantalón de verano','Guantes de motocicleta','Bota', 'Zapato', 'Abrigo', 'Bufanda', 'Traje', 'Otros');
        
        foreach ($vestuario as $descripcion){
            $entity = new infoTipoVestuario();       
            $entity->setDescripcion($descripcion);             
            $manager->persist($entity);
        }
        
        $manager->flush();
        $this->cargarExpedientes($manager);
        
        $expedientes = $manager->getRepository('ExpedientesBundle:Expediente')->findAll();
        $this->cargarMaterialInformatico($manager,$expedientes);
        $this->cargarMaterialOperativo($manager, $expedientes);
    }
    
    private function cargarExpedientes(ObjectManager $manager){
        
        $estadosE = $manager->getRepository('GestionBundle:infoTipoEstadoExpediente')->findAll();
        $empresasE = $manager->getRepository('GestionBundle:infoTipoEmpresa')->findAll();
        $adjudicatariosE = $manager->getRepository('GestionBundle:infoTipoAdjudicatario')->findAll();
        
        for ($i=1; $i<=24; $i++){
            $entity = new Expediente(); 
        
            $ref='Expediente N.'.$i;
            if ($i<9)
                $tit='2013/00'.$i;
            else
                $tit='2013/0'.$i;
           
            $estado=$estadosE[array_rand($estadosE)];
            $fInicio = new \DateTime('now - '.rand(10, 30).' days');
            $fFin = new \DateTime('now - '.rand(1, 10).' days');
            
            if($estado=='Tramitado')
                $entity->asignarDatos($ref,$tit,$estado,$empresasE[array_rand($empresasE)],
                  $adjudicatariosE[array_rand($adjudicatariosE)],$fInicio,$fFin,rand(1,999999).rand(1,999),$ref.'-'.$tit,'Campo para descripción 2','Campo para descripción 3');
            else
                $entity->asignarDatos($ref,$tit,$estado,$empresasE[array_rand($empresasE)],
                  $adjudicatariosE[array_rand($adjudicatariosE)],$fInicio,null,rand(1,999999).rand(1,999),$ref.'-'.$tit,'Campo para descripción 2','Campo para descripción 3');
            
            $manager->persist($entity);    
            $manager->flush();
        }
    }
        
    private function cargarMaterialInformatico(ObjectManager $manager, $expedientes){
        
        $infoTipoInformatica = $manager->getRepository('GestionBundle:infoTipoInformatica')->findAll();       
        
        for ($i=1; $i<=50; $i++){
            $entity = new MaterialInformatico();         
            $exp = $expedientes[array_rand($expedientes)]; 
            $nserie = array('12223-WRPX-TR-01', 'HIIHKH', '090908-27384905-X', '1234ABC-D', '22BB-3TRO-Z','ABCD-12345-WXYZ', '998374S');
            
            $entity->setfkExpediente($exp);
            $entity->setTipo($infoTipoInformatica[array_rand($infoTipoInformatica)]);
            $entity->setObservaciones("Observaciones para el material informático del expediente ".$exp->getReferencia());
            $entity->setNumSerie($nserie[array_rand($nserie)]);
            $entity->setModelo("Modelo del material informático");
            $entity->setMarca("Marca del material informático");
            $entity->setDestino("Destino del material informático");
            $entity->setDescripcion("Descripción para el material informático del expediente ".$exp->getReferencia());
            $entity->setCaracteristicas("Características del material informático");
            $entity->setCantidad(rand(0, 500));
            
            $manager->persist($entity);    
            $manager->flush();
        }        
    }
    
    private function cargarMaterialOperativo(ObjectManager $manager, $expedientes){
        
        $infoTipoPolicial = $manager->getRepository('GestionBundle:infoTipoPolicial')->findAll();       
        
        for ($i=1; $i<=50; $i++){
            $entity = new MaterialPolicial();       
            $exp = $expedientes[array_rand($expedientes)]; 
            $nserie = array('12223-WRPX-TR-01', 'HIIHKH', '090908-27384905-X', '1234ABC-D', '22BB-3TRO-Z','ABCD-12345-WXYZ', '998374S');
            
            $entity->setfkExpediente($exp);
            $entity->setTipo($infoTipoPolicial[array_rand($infoTipoPolicial)]);
            $entity->setObservaciones("Observaciones para el material operativo del expediente ".$exp->getReferencia());
            $entity->setNumSerie($nserie[array_rand($nserie)]);
            $entity->setModelo("Modelo del material operativo");
            $entity->setMarca("Marca del material operativo");
            $entity->setDestino("Destino del material operativo");
            $entity->setDescripcion("Descripción para el material operativo del expediente ".$exp->getReferencia());
            $entity->setTalla("Talla del material operativo");
            $entity->setCantidad(rand(0, 500));
            
            $manager->persist($entity);    
            $manager->flush();
        }        
    }
}

