<?php

namespace Tfe\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TfeCoreBundle::index.html.twig');
    }
}
