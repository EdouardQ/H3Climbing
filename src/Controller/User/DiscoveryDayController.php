<?php

namespace App\Controller\User;

use App\Entity\DiscoveryDay;
use App\Entity\Registration;
use App\Form\DiscoveryDayType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/my-space/discovery-day', name: 'user.discovery_day.')]
class DiscoveryDayController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        $entity = new DiscoveryDay();
        $form = $this->createForm(DiscoveryDayType::class, $entity)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entity->setOrganizer($this->getUser());

            $registration = new Registration();
            $registration->setDiscoveryDay($entity);
            $registration->setUser($entity->getOrganizer());

            $this->em->persist($entity);
            $this->em->persist($registration);

            $this->em->flush();

            $this->addFlash('success_discovery_day', 'Your discovery day has been created.');
            return $this->redirectToRoute('user.homepage');
        }

        return $this->render('user/discovery_day/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}