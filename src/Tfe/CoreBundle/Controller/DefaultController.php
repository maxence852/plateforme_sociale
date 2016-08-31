<?php

namespace Tfe\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

    }

    public function ContactAction()
    {
        return $this->render('TfeCoreBundle:Contact:contact.html.twig');
    }
}
