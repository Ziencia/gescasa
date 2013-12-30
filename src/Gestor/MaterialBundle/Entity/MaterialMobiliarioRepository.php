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
        
        $largo = $data->getLargo();
        $largo = substr($largo, 0, strpos($largo, ' '));
        $largo = str_replace(',', '.', $largo);
        
        $ancho = $data->getAncho();
        $ancho = substr($ancho, 0, strpos($ancho, ' '));
        $ancho = str_replace(',', '.', $ancho);
        
        $alto = $data->getAlto();
        $alto = substr($alto, 0, strpos($alto, ' '));
        $alto = str_replace(',', '.', $alto);
        
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
                $largo,
                $ancho,
                $alto);
        
        $em = $this->getEntityManager();
        $em->persist($materialMobiliario);
        $em->flush();
        
        return $materialMobiliario;
    }
}
