<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use App\Repository\AuteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AuteurTypeNote;

/**
 * @Route("/auteur")
 */
class AuteurController extends AbstractController
{
    /**
     * @Route("/", name="auteur_index", methods={"GET"})
     */
    public function action3(AuteurRepository $auteurRepository): Response
    {
        return $this->render('auteur/index.html.twig', [
            'auteurs' => $auteurRepository->findAll(),
        ]);
    }


      /**
     * @Route("/AuteurGenre", name="auteur_genre", methods={"GET"})
     */
    public function action20(AuteurRepository $auteurRepository): Response
    {
        return $this->render('auteur/showAuteurGenre.html.twig', [
            'auteurs' => $auteurRepository->selectListeAuteurGenre(),
        ]);
    }

     /**
     * @Route("/auteurMinimum", name="auteur_Minimum", methods={"GET"})
     */
    public function action16(AuteurRepository $auteurRepository): Response
    {
         // Récupère l'Entity Manager
         $em = $this->getDoctrine()->getManager();

         // Récupère le repository Objectif
         $repository = $em->getRepository(Auteur::class);
         $listeAuteur = $repository->selectListeAuteurTroisLivres();
        return $this->render('auteur/auteurTroisMinimum.html.twig', [
            'auteurs' => $listeAuteur,
        ]);
    }

    /**
     * @Route("/new", name="auteur_new", methods={"GET", "POST"})
     */
    public function action5(Request $request, EntityManagerInterface $entityManager): Response
    {
        $auteur = new Auteur();
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($auteur);
            $entityManager->flush();

            return $this->redirectToRoute('auteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('auteur/new.html.twig', [
            'auteur' => $auteur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="auteur_show", methods={"GET"})
     */
    public function action4et21(Auteur $auteur): Response
    {

        $repo = $this->getDoctrine()
        ->getManager()
        ->getRepository(Auteur::class);
        $id = $auteur->getId();
        $genres = $repo->selectAuteurGenre($id);

        return $this->render('auteur/show.html.twig', [
            'auteur' => $auteur, 'genres' => $genres
        ]);
    }

    /**
     * @Route("/{id}/edit", name="auteur_edit", methods={"GET", "POST"})
     */
    public function action6(Request $request, Auteur $auteur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('auteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('auteur/edit.html.twig', [
            'auteur' => $auteur,
            'form' => $form->createView(),
        ]);
    }


      /**
     * @Route("/{id}/editNote", name="auteur_edit_note", methods={"GET", "POST"})
     */
    public function action26(Request $request, Auteur $auteur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AuteurTypeNote::class, $auteur);
        
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Auteur::class);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $laNote = $form["lesNotes"]->getData();
            
            $id = $auteur->getId();
            $repository->modifierNoteAuteur($laNote,$id);

            return $this->redirectToRoute('auteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('auteur/auteurNote.html.twig', [
            'auteur' => $auteur,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="auteur_delete", methods={"POST"})
     */
    public function action7(Request $request, Auteur $auteur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$auteur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($auteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('auteur_index', [], Response::HTTP_SEE_OTHER);
    }
}
