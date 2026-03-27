<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\WhatRepository;
use App\Repository\WhatUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\WhatUser;

final class WhatController extends AbstractController
{
    #[Route('/what', name: 'app_what')]
    public function index(WhatRepository $whatRepo): Response
    {
        $user = $this->getUser();
        $notAssignedWhats = $whatRepo->findNotAssignedToUser($user);
        $userWhat = $user->getWhatUsers()->toArray();

        return $this->render('what/index.html.twig', [
            'whats' => $notAssignedWhats,
            'whatsTrack' => $userWhat,
        ]);
    }

    #[Route('/what/add/{whatId}', name: 'app_what_add')]
    public function add(
        WhatRepository $whatRepo, 
        int $whatId, 
        EntityManagerInterface $em
    ): Response
    {
        $user = $this->getUser();
        $what = $whatRepo->find($whatId);

        $whatUser = new WhatUser();
        $whatUser->setUser($user);
        $whatUser->setWhat($what);

        $em->persist($whatUser);
        $em->flush();

        return $this->redirectToRoute('app_what');
    }

    #[Route('/what/remove/{whatId}', name: 'app_what_remove')]
    public function remove(
        WhatRepository $whatRepo, 
        WhatUserRepository $whatUserRepo,
        int $whatId, 
        EntityManagerInterface $em
    ): Response
    {
        $user = $this->getUser();
        $what = $whatRepo->find($whatId);

        $whatUser = $whatUserRepo->findOneBy([
            'user' => $user,
            'what' => $what
        ]);

        $em->remove($whatUser);
        $em->flush();

        return $this->redirectToRoute('app_what');
    }

}
