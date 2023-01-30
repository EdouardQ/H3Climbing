<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Repository\RegistrationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/user', name: 'user.')]
class HomepageController extends AbstractController
{
    private RegistrationRepository $registrationRepository;

    public function __construct(RegistrationRepository $registrationRepository)
    {
        $this->registrationRepository = $registrationRepository;
    }

    #[Route(path: '/', name: 'homepage')]
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $upcomingRegistrations = $this->registrationRepository->findUpcomingDiscoveryDays($user);
        $pastRegistrations = $this->registrationRepository->findOldDiscoveryDays($user);

        return $this->render('user/homepage/index.html.twig', [
            'upcomingRegistrations' => $upcomingRegistrations,
            'pastRegistrations' => $pastRegistrations,
        ]);
    }
}