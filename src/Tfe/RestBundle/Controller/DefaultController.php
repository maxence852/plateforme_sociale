<?php

namespace Tfe\RestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TfeRestBundle:Default:index.html.twig');
    }
}
