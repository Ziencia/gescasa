<?php

namespace Gestor\ExpedientesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ExpedientesBundle:Default:index.html.twig');
    }
}
