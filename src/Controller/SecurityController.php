<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{

    #[Route(path: '/api/login', name: 'api_login', methods: ['POST'])]
    public function  login()
    {
        $person = $this->getUser();
        return $this->json([
            'username' => $person->getUserIdentifier(),
            'roles' => $person->getRoles(),
        ]);
    }


    #[Route(path: '/api/logout', name: 'api_logout', methods: ['POST'])]
    public function  logout()
    {
    }
}
