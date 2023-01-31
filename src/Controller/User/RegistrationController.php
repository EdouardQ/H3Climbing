<?php

namespace App\Controller\User;

use App\Entity\DiscoveryDay;
use App\Entity\Registration;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/register', name: 'user.register.')]
class RegistrationController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/add/{id}', name: 'add')]
    public function add(DiscoveryDay $discoveryDay): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $registration = new Registration();
        $registration->setDiscoveryDay($discoveryDay);
        $registration->setUser($user);

        $this->em->persist($registration);
        $this->em->flush();

        $this->addFlash('success_registration', 'You have successfully registered for this discovery day.');
        return $this->redirectToRoute('discovery_day.show', ['id' => $discoveryDay->getId()]);
    }
}
