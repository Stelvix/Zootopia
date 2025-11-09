<?php

namespace App\Controller;

use App\Repository\AnimauxRepository;
use App\Repository\EnclosRepository;
use App\Repository\EspaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MenuController extends AbstractController
{
     public function menu(EspaceRepository $espaceRepository, EnclosRepository $enclosRepository, AnimauxRepository $animauxRepository): Response
    {
        $espaceRepository = $espaceRepository->findAll();
        $enclosRepository = $enclosRepository->findAll();
        $animauxRepository = $animauxRepository->findAll();

        return $this->render('menu/index.html.twig', [
            'controller_name' => 'MenuController',
            'espaces' => $espaceRepository,
            'enclos' => $enclosRepository,
            'animaux' => $animauxRepository,
        ]);
    }
}
