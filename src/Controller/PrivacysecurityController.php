<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrivacysecurityController extends AbstractController
{
    #[Route('/privacy', name: 'app_privacy_security')]
    public function index(): Response
    {
        return $this->render('privacy_security/index.html.twig', [
            'controller_name' => 'PrivacysecurityController',
        ]);
    }
}
