<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/{reactRouting}", name="app", defaults={"reactRouting": null})
     */
    public function index(): Response
    {
        return $this->render('app/index.twig');
    }

    /**
     * @Route("/about_us", name="about_us")
     */
    public function aboutUs(): Response
    {
        return $this->render('app/about_us.twig');
    }
}
