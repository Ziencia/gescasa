<?php

namespace Gestor\MaterialBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MaterialAutomocionRepository
 *
 */
class MaterialVestuarioRepository extends EntityRepository
{
    
    public function altaMaterialVestuario($data,$expediente){
        
        $materialVestuario = new MaterialVestuario();        
        
        $materialVestuario->asignarDatos(
                $expediente,
                $data->getDescripcion(),
                $data->getTipo(),
                $data->getMarca(),
                $data->getModelo(),
                $data->getNumSerie(),
                $data->getDestino(),
                $data->getCantidad(),
                $data->getObservaciones(),
                $data->getTalla(),
                $data->getColor(),
                $data->getSexo()
                );
        
        $em = $this->getEntityManager();
        $em->persist($materialVestuario);
        $em->flush();
        
        return $materialVestuario;
    }
}