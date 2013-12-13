<?php

namespace Gestor\UsuarioBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UsuarioRepository extends EntityRepository{

    public function queryTodosUsuarios(){
        $em = $this->getEntityManager();       
        
        $consulta = $em->getRepository('UsuarioBundle:Usuario')->findAll();
        
        return $consulta;        
    }
    
    public function findTodosUsuarios(){
        return $this->queryTodosUsuarios()->getResult();
    }
    
    public function queryUsuariosAutorizados(){
        $em = $this->getEntityManager();
        
        $consulta = $em->createQuery(
                'SELECT u FROM UsuarioBundle:Usuario u 
                    WHERE u.autorizado = true');
        
        return $consulta;
    }
    
    public function findUsuariosAutorizados(){
        return $this->queryUsuariosAutorizados()->getResult();
    }
}
    

