<?php

namespace App\Controller;

use App\Entity\Enclos;
use App\Form\EnclosType;
use App\Repository\EnclosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/enclos')]
final class EnclosController extends AbstractController
{
    #[Route(name: 'app_enclos_index', methods: ['GET'])]
    public function index(EnclosRepository $enclosRepository): Response
    {
        return $this->render('enclos/index.html.twig', [
            'enclos' => $enclosRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_enclos_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $enclo = new Enclos();
        $form = $this->createForm(EnclosType::class, $enclo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($enclo);
            $entityManager->flush();
            return $this->redirectToRoute('app_enclos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('enclos/new.html.twig', [
            'enclo' => $enclo,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}', name: 'app_enclos_show', methods: ['GET'])]
    public function show(Enclos $enclo): Response
    {
        return $this->render('enclos/show.html.twig', [
            'enclo' => $enclo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_enclos_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Enclos $enclo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EnclosType::class, $enclo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_enclos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('enclos/edit.html.twig', [
            'enclo' => $enclo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_enclos_delete', methods: ['POST'])]
    public function delete(Request $request, Enclos $enclo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$enclo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($enclo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_enclos_index', [], Response::HTTP_SEE_OTHER);
    }
}
