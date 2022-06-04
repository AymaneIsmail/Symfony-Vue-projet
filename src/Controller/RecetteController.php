<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\Request;

class RecetteController extends AbstractController
{
    /**
     * Function de serialisation 
     * @return Response sous la from d'un objet JSON $response
     */
    public function jsonRender($object): Response
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($object, 'json');
        // dd($productListJSON);
        $response = new Response($jsonContent);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    #[Route('/recette', name: 'home_recette')]
    public function home(): Response
    {
        return $this->render('recette/index.html.twig');
    }

    #[Route('/recette/show', name: 'show_recette')]
    public function showAll(RecetteRepository $recetteRepository): Response
    {
        $recettes = $recetteRepository->findAll();

        return self::jsonRender($recettes);
    }

    #[Route('/recette/show/{id}', name: 'showOene_recette')]
    public function index(RecetteRepository $recetteRepository, int $id): Response
    {
        $recette = $recetteRepository->find($id);

        // $encoders = [new JsonEncoder()];
        // $normalizers = [new ObjectNormalizer()];
        // $serializer = new Serializer($normalizers, $encoders);

        // $jsonContent = $serializer->serialize($recettes, 'json');
        // // dd($productListJSON);
        // $response = new Response($jsonContent);
        // $response->headers->set('Content-Type', 'application/json');

        return self::jsonRender($recette);
    }

    #[Route('recette/new', name: 'new_recette')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recette = $form->getData();

            $manager->persist($recette);
            $manager->flush();

            // CORS error -> headers dans la requête {'Access-Control-Allow-Origin', '*'} 
            // Peut être une erreur due à la méthod de soumission du formulaire en 'GET' alors que celui-ci doit être en 'POST' 
            // return self::jsonRender($recette);

            $this->addFlash('success', 'Recette crée avec succès');
            return $this->redirectToRoute('home_recette');
        }

        return $this->render('recette/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('recette/edit/{id}', name: 'edit_recette')]
    public function edit(RecetteRepository $recette, EntityManagerInterface $manager, Request $request, int $id): Response
    {
        $recette = $recette->findOneBy(['id' => $id]);
        $form = $this->createForm(RecetteType::class, $recette);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recette = $form->getData();

            $manager->persist($recette);
            $manager->flush();

            //     // CORS error -> headers dans la requête {'Access-Control-Allow-Origin', '*'} 
            //     // Peut être une erreur due à la méthod de soumission du formulaire en 'GET' alors que celui-ci doit être en 'POST' 
            //     // return self::jsonRender($recette);
            $this->addFlash('success', 'Recette modifié avec succès');
            return $this->redirectToRoute('home_recette');
        }
        return $this->render('recette/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('recette/delete/{id}', name: 'delete_recette')]
    public function delete(RecetteRepository $recette, EntityManagerInterface $manager, int $id): Response
    {
        $recette = $recette->findOneBy(['id' => $id]);
        $manager->remove($recette);
        $manager->flush();

        $this->addFlash('delete', 'Recette supprimé');

        return $this->redirectToRoute('home_recette');
    }
}
