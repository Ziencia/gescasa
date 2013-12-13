<?php

namespace Gestor\GestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GestionController extends Controller
{
    public function indiceAction()
    {
        return $this->render('GestionBundle:Default:index.html.twig');
    }
}
