<?php

namespace App\Controller;

use App\Entity\DiscoveryDay;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiscoveryDayController extends AbstractController
{
    #[Route('/discovery-day/{id}', name: 'discovery_day.show')]
    public function getDiscoveryDay(DiscoveryDay $discoveryDay): Response
    {
        return $this->render('discovery_day/show.html.twig', [
            'discoveryDay' => $discoveryDay,
        ]);
    }
}