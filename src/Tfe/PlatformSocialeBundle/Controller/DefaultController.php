<?php

namespace Tfe\PlatformSocialeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TfePlatformSocialeBundle:Default:index.html.twig');
    }
}
