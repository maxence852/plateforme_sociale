<?php

namespace Tfe\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TfeUserBundle::layout.html.twig');
    }

}
