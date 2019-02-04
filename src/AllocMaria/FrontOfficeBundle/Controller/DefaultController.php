<?php

namespace AllocMaria\FrontOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AllocMariaFrontOfficeBundle:Default:index.html.twig');
    }
}
