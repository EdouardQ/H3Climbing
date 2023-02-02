<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\DiscoveryDay;
use App\Entity\User;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function list(): Response
    {
        $repository = $this->em->getRepository(DiscoveryDay::class);

        $upcomingDiscoveryDays = $repository->findUpcomingDiscoveryDays();
        $pastDiscoveryDays = $repository->findPastDiscoveryDays();

        return $this->render('discovery_day/list.html.twig', [
            'upcomingDiscoveryDays' => $upcomingDiscoveryDays,
            'pastDiscoveryDays' => $pastDiscoveryDays,
        ]);
    }

    #[Route('/discovery-day/{id}', name: 'discovery_day.show')]
    public function show(DiscoveryDay $discoveryDay, Request $request): Response
    {
        /** @var User|null $user */
        $user = $this->getUser();

        if ($discoveryDay->getDate() < new \DateTime() && $user && in_array($this->getUser(), $discoveryDay->getRegistredUsers())) {
            $comment = new Comment();
            $form = $this->createForm(CommentType::class, $comment)->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $comment->setDiscoveryDay($discoveryDay);
                $comment->setUser($user);

                $this->em->persist($comment);
                $this->em->flush();

                return $this->redirectToRoute('discovery_day.show', ['id' => $discoveryDay->getId()]);
            }
        }

        return $this->render('discovery_day/show.html.twig', [
            'discoveryDay' => $discoveryDay,
            'form' => $form ?? null,
        ]);
    }
}