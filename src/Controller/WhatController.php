<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\WhatRepository;

final class WhatController extends AbstractController
{
    #[Route('/what', name: 'app_what')]
    public function index(WhatRepository $whatRepo): Response
    {
        $whats = $whatRepo->findAll();

        return $this->render('what/index.html.twig', [
            'whats' => $whats
        ]);
    }

    #[Route('/what/add', name: 'app_what_add')]
    public function add(WhatRepository $whatRepo): Response
    {
        $whats = $whatRepo->findAll();

        return $this->render('what/index.html.twig', [
            'whats' => $whats
        ]);
    }
}
