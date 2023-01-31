<?php

namespace App\Controller;

use App\Entity\DiscoveryDay;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiscoveryDayController extends AbstractController
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/discovery-days', name: 'discovery_day.list')]
    public function listDiscoveryDays(): Response
    {
        return $this->render('discovery_day/list.html.twig', [
            'discoveryDays' => $this->em->getRepository(DiscoveryDay::class)->findBy([], ['date' => 'DESC']),
        ]);
    }

    #[Route('/discovery-day/{id}', name: 'discovery_day.show')]
    public function getDiscoveryDay(DiscoveryDay $discoveryDay): Response
    {
        return $this->render('discovery_day/show.html.twig', [
            'discoveryDay' => $discoveryDay,
        ]);
    }
}