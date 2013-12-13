<?php

namespace Gestor\MaterialBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MaterialAutomocionRepository
 *
 */
class MaterialAutomocionRepository extends EntityRepository
{
    
    public function altaMaterialAutomocion($data,$expediente){
        
        $materialAutomocion = new MaterialAutomocion();        
        
        $materialAutomocion->asignarDatos(
                $expediente,
                $data->getDescripcion(),
                $data->getTipo(),
                $data->getMarca(),
                $data->getModelo(),
                $data->getNumSerie(),
                $data->getDestino(),
                $data->getCantidad(),
                $data->getObservaciones(),
                $data->getBastidor(),
                $data->getConcesionario(),
                $data->getKit(),
                $data->getMotor(),
                $data->getColor(),
                $data->getMatricula()
                );
        
        $em = $this->getEntityManager();
        $em->persist($materialAutomocion);
        $em->flush();
        
        return $materialAutomocion;
    }
}