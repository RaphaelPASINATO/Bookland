<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/genre")
 */
class GenreController extends AbstractController
{
    /**
     * @Route("/", name="genre_index", methods={"GET"})
     */
    public function action1(GenreRepository $genreRepository): Response
    {
        return $this->render('genre/index.html.twig', [
            'genres' => $genreRepository->findAll(),
        ]);
    }

      /**
     * @Route("/genreAuteur", name="genre_auteur", methods={"GET"})
     */
    public function action18(GenreRepository $genreRepository): Response
    {
        return $this->render('genre/showGenreAuteur.html.twig', [
            'genres' => $genreRepository->selectListeGenreAuteur(),
        ]);
    }

    /**
     * @Route("/new", name="genre_new", methods={"GET", "POST"})
     */
    public function action2(Request $request, EntityManagerInterface $entityManager): Response
    {
        $genre = new Genre();
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($genre);
            $entityManager->flush();

            return $this->redirectToRoute('genre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('genre/new.html.twig', [
            'genre' => $genre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="genre_show", methods={"GET"})
     */
    public function action19et22(Genre $genre): Response
    {
        $repo = $this->getDoctrine()
        ->getManager()
        ->getRepository(Genre::class);
        $id = $genre->getId();
     $nbPages = $repo->nombreTotalPagesParGenre($id);
     $nbPagesMoyen = $repo->nombreMoyenPagesParGenre($id);
        return $this->render('genre/show.html.twig', [
            'genre' => $genre,
            'nbPages' => $nbPages,
            'nbPagesMoyen' => $nbPagesMoyen
        ]);
    }

    /**
     * @Route("/{id}/edit", name="genre_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Genre $genre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('genre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('genre/edit.html.twig', [
            'genre' => $genre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="genre_delete", methods={"POST"})
     */
    public function action24(Request $request, Genre $genre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$genre->getId(), $request->request->get('_token'))) {
            //$entityManager->remove($genre);
            $entityManager->flush();


            $repo = $this->getDoctrine()
            ->getManager()
            ->getRepository(Genre::class);
            $rep = $repo->supprimerGenreAucunLivre($genre);
        }

        return $this->redirectToRoute('genre_index', [], Response::HTTP_SEE_OTHER);
    }
}
