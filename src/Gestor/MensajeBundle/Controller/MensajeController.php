<?php

namespace Gestor\MensajeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gestor\UsuarioBundle\Entity\Usuario;
use Gestor\MensajeBundle\Entity\Mensaje;

class MensajeController extends Controller
{
    public function verAction(Usuario $usuario)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$usuario) {
            throw $this->createNotFoundException('No se ha encontrado el usuario a auditar');
        }
        
        $mensajes = $em->getRepository('MensajeBundle:Mensaje')->findBy(
                array('fkusuario' => $usuario),
                array('fecha' => 'DESC'));
                
        $descripcion = 'INFO: Administracion auditar usuario: ' . $usuario->getTip() ;
        $mensaje = new Mensaje($this->getUser()->getId(),new \DateTime(),$descripcion);
        $em->getRepository('MensajeBundle:Mensaje')->altaMensaje($mensaje);
            
        return $this->render('MensajeBundle:Default:ver.html.twig', array('usuario' => $usuario, 'mensajes' => $mensajes));
    }
}
