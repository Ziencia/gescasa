<?php

namespace Gestor\GestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gestor\MensajeBundle\Entity\Mensaje;

class GestionController extends Controller
{
    public function indiceAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $descripcion = 'INFO: Gestion indice';
        $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
        $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
        
        return $this->render('GestionBundle:Default:index.html.twig');
    }
}
