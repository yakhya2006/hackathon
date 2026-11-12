<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\OrganisateurRepository;

final class OrganisateurController extends AbstractController
{
    #[Route('/organisateur', name: 'app_organisateur')]
    public function index(OrganisateurRepository $organisateurRepository): Response
    {
        $organisateurs = $organisateurRepository->findAll();
        return $this->render('organisateur/index.html.twig', [
            'organisateurs' => $organisateurs,
        ]);
    }
}
