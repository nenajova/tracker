<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\WhatRepository;
use App\Repository\TrackerRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Tracker;

final class TrackController extends AbstractController
{
    #[Route('/track', name: 'app_track')]
    public function index(TrackerRepository $trackerRepo): Response
    {
        $user = $this->getUser();
        $trackers = $trackerRepo->findByUser($user);
        // dd($trackers);

        return $this->render('track/index.html.twig', [
            'controller_name' => 'TrackController',
            'trackers' => $trackers,
        ]);
    }

    #[Route('/track/add/{whatId}', name: 'app_track_add')]
    public function add(WhatRepository $whatRepo, int $whatId, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $what = $whatRepo->find($whatId);

        $tracker = new Tracker();
        $tracker->setUser($user);
        $tracker->setWhat($what); 
        $tracker->setTime(new \DateTime('now', new \DateTimeZone('Europe/Belgrade')));

        $em->persist($tracker);
        $em->flush();

        return $this->redirectToRoute('app_home');
    }
}
