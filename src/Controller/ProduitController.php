<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'app_produit')]
    public function index(): Response
    {
        return $this->render('produit/index.html.twig');
    }

    #[Route('/produit/create', name: 'produit_create')]
    public function create(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $managerRegistry->getManager(); 
            $manager->persist($produit); 
            $manager->flush(); 

            $this->addFlash('success', 'La catégorie a bien été créée');

            return $this->redirectToRoute('app_produit');
        }


        return $this->render('produit/create.html.twig', [
            'produitForm' => $form->createView()
        ]);
    }

}

