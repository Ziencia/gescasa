<?php

namespace Gestor\MaterialBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MaterialInformaticoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MaterialInformaticoRepository extends EntityRepository
{
    
    public function altaMaterialInformatico($data,$expediente){
        
        $materialInformatico = new MaterialInformatico();
        
        $materialInformatico->asignarDatos(
                $expediente,
                $data->getDescripcion(),
                $data->getTipo(),
                $data->getMarca(),
                $data->getModelo(),
                $data->getCaracteristicas(),
                $data->getNumSerie(),
                $data->getDestino(),
                $data->getCantidad(),
                $data->getObservaciones());
        
        $em = $this->getEntityManager();
        $em->persist($materialInformatico);
        $em->flush();
        
        return $materialInformatico;
    }
}
