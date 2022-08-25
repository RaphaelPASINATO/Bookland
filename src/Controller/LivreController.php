<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SelectionAnneeType;
use App\Form\SelectionLivreAnneeNote;
use App\Form\SelectionRechercheLivre;
use App\Form\LivreNoteType;

/**
 * @Route("/livre")
 */
class LivreController extends AbstractController
{
    /**
     * @Route("/", name="livre_index", methods={"GET"})
     */
    public function action8(LivreRepository $livreRepository): Response
    {
        return $this->render('livre/index.html.twig', [
            'livres' => $livreRepository->findAll(),
        ]);
    }

      /**
     * @Route("/parite", name="livre_parite", methods={"GET"})
     */
    public function action17(LivreRepository $livreRepository): Response
    {
        return $this->render('livre/showParite.html.twig', [
            'livres' => $livreRepository->selectListeLivreParite(),
        ]);
    }

       /**
     * @Route("/nationaliteLivre", name="livre_nationalite", methods={"GET"})
     */
    public function action14(LivreRepository $livreRepository): Response
    {
        return $this->render('livre/showLivreNationalite.html.twig', [
            'livres' => $livreRepository->selectListeAuteurNationalite(),
        ]);
    }



      /**
     * @Route("/showRecherche", name="livre_Partie_Titre", methods={"GET", "POST"})
     */
    public function action25(Request $request): Response
    {
        $titreCible = null;
        $form = $this->createForm(SelectionRechercheLivre::class);
        $form->handleRequest($request);
     
        // Récupère l'Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Récupère le repository Livre
        $repository = $em->getRepository(Livre::class);

        // Récupère la liste de tous les objets livre
        $titreCible = $repository->findAll();
        if($form->isSubmitted()) {
            $data = $form->getData();
            $titre = $data['livreSelect'];
            $titreCible = $repository->selectLivrePartieTitre($titre);
        }

        // On appelle la vue en lui fournissant la liste des livres  -
        return $this->render(
            'livre/showPartieTitre.html.twig',
            ['form' => $form->createView(),'titreCible' => $titreCible]
        );
    }



    /**
     * @Route("/showAnnee", name="livre_Annee", methods={"GET", "POST"})
     */
    public function action13(Request $request): Response
    {
        $anneeCible = null;
        $form = $this->createForm(SelectionAnneeType::class);
        $form->handleRequest($request);
     
        // Récupère l'Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Récupère le repository Livre
        $repository = $em->getRepository(Livre::class);

        // Récupère la liste de tous les objets livre
        $anneeCible = $repository->findAll();
        if($form->isSubmitted()) {
            $data = $form->getData();
            $anneeMin = $data['AnneeMinSelect'];
            $anneeMax = $data['AnneeMaxSelect'];
            $anneeCible = $repository->selectLivreAnnee($anneeMin,$anneeMax);
        }

        // On appelle la vue en lui fournissant la liste des livres  -
        return $this->render(
            'livre/showAnnee.html.twig',
            ['form' => $form->createView(),'anneeCible' => $anneeCible]
        );
    }


    
    /**
     * @Route("/showAnneeNote", name="livre_AnneeNote", methods={"GET", "POST"})
     */
    public function action15(Request $request): Response
    {
        $anneeCible = null;
        $form = $this->createForm(SelectionLivreAnneeNote::class);
        $form->handleRequest($request);
     
        // Récupère l'Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Récupère le repository Livre
        $repository = $em->getRepository(Livre::class);

        // Récupère la liste de tous les objets livre
        $anneeCible = $repository->findAll();
        if($form->isSubmitted()) {
            $data = $form->getData();
            $dateMin = $data['dateMinSelect'];
            $dateMax = $data['dateMaxSelect'];
            $noteMin = $data['noteMin'];
            $noteMax = $data['noteMax'];
            $anneeCible = $repository->selectLivreParDateEtNote($dateMin,$dateMax,$noteMin,$noteMax);
        }

        // On appelle la vue en lui fournissant la liste des livres  -
        return $this->render(
            'livre/showAnneeNote.html.twig',
            ['form' => $form->createView(),'anneeCible' => $anneeCible]
        );
    }



    /**
     * @Route("/new", name="livre_new", methods={"GET", "POST"})
     */
    public function action10(Request $request, EntityManagerInterface $entityManager): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="livre_show", methods={"GET"})
     */
    public function action9(Livre $livre): Response
    {
      


        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="livre_edit", methods={"GET", "POST"})
     */
    public function action11(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/editNote", name="livre_edit_note", methods={"GET", "POST"})
     */
    public function action23(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivreNoteType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('livre/editNote.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="livre_delete", methods={"POST"})
     */
    public function action12(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($livre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
    }
}
