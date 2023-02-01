<?php

namespace App\Controller\User;

use App\Entity\DiscoveryDay;
use App\Entity\Registration;
use App\Entity\User;
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

    #[Route('/list', name: 'list')]
    public function list(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $discoveryDays = $this->em->getRepository(DiscoveryDay::class)->findManagebleDiscoveryDays($user);

        return $this->render('user/discovery_day/list.html.twig', [
            'discoveryDays' => $discoveryDays,
        ]);
    }

    #[Route('/form/{id}', name: 'form', requirements: ['id' => '\d+'], defaults: ['id' => null])]
    public function form(?int $id, Request $request): Response
    {
        if ($id) {
            $entity = $this->em->getRepository(DiscoveryDay::class)->find($id);

            if ($this->getUser() !== $entity->getOrganizer()) {
                return new Response('', Response::HTTP_FORBIDDEN);
            }
        } else {
            $entity = new DiscoveryDay();
        }

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

        return $this->render('user/discovery_day/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}