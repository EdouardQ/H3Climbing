<?php

namespace App\Controller\User;

use App\Entity\DiscoveryDay;
use App\Entity\Photo;
use App\Form\PhotoType;
use App\Service\PhotoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/my-space/photo', name: 'user.photo.')]
class PhotoController extends AbstractController
{
    private EntityManagerInterface $em;
    private PhotoService $photoService;

    public function __construct(EntityManagerInterface $em, PhotoService $photoService)
    {
        $this->em = $em;
        $this->photoService = $photoService;
    }

    #[Route('/add/{id}', name: 'add')]
    public function add(DiscoveryDay $discoveryDay, Request $request): Response
    {
        if (!in_array($this->getUser(), $discoveryDay->getRegistredUsers())) {
            return new Response('', Response::HTTP_FORBIDDEN);
        }

        $form = $this->createForm(PhotoType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = new Photo();
            $photo->setDiscoveryDay($discoveryDay);
            $photo->setUploadedBy($this->getUser());
            $photo->setUploadedAt(new \DateTimeImmutable());
            $photo->setFilename($this->photoService->upload($form->get('filename')->getData()));

            $this->em->persist($photo);
            $this->em->flush();

            $this->addFlash('success_photo', 'Photo added with success!');
            return $this->redirectToRoute('user.homepage');
        }

        return $this->render('user/photo/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Photo $photo): Response
    {
        if ($photo->getUploadedBy() !== $this->getUser()) {
            return new Response('', Response::HTTP_FORBIDDEN);
        }

        $this->em->remove($photo);
        $this->em->flush();

        $this->addFlash('success_photo', 'Photo deleted with success!');
        return $this->redirectToRoute('user.homepage');
    }
}