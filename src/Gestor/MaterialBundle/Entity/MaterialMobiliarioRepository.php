<?php

namespace Gestor\MaterialBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MaterialMobiliarioRepository
 *
 */
class MaterialMobiliarioRepository extends EntityRepository
{
    
    public function altaMaterialMobiliario($data,$expediente){
        
        $materialMobiliario = new MaterialMobiliario();
               
        $materialMobiliario->asignarDatos(
                $expediente,
                $data->getDescripcion(),
                $data->getTipo(),
                $data->getMarca(),
                $data->getModelo(),
                $data->getNumSerie(),
                $data->getDestino(),
                $data->getCantidad(),
                $data->getObservaciones(),
                $data->getLargo(),
                $data->getAncho(),
                $data->getAlto());
        
        $em = $this->getEntityManager();
        $em->persist($materialMobiliario);
        $em->flush();
        
        return $materialMobiliario;
    }
}
