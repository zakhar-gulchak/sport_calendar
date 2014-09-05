<?php

namespace Zahar\SportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SportBundle:Default:index.html.twig', array('name' => $name));
    }
}
