<?php

namespace App\Controller;

use App\Entity\ArticleKind;
use App\Form\ArticleKindType;
use App\Repository\ArticleKindRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArticleKindController extends AbstractController
{
    #[Route('/article/kind', name: 'article_kind_listing')]
    public function articleKinds(ArticleKindRepository $articleKindRepository)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_main');
        }
        $articleKinds = $articleKindRepository->findAll();
        return $this->render('article_kind/index.html.twig', [
            'articleKinds' => $articleKinds
        ]);
    }

    #[Route('/kind/new', name: 'articleKind_new')]
    public function articleKindNew(Request $request, EntityManagerInterface $entityManager)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_main');
        }
        $newArticleKind = new ArticleKind();
        $form = $this->createForm(ArticleKindType::class, $newArticleKind);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $articleKindToSave = $form->getData();
            $entityManager->persist($articleKindToSave);
            $entityManager->flush();

            $this->addFlash('success', 'Your type successfully crated');
            return $this->redirectToRoute('article_kind_listing');
        }
        return $this->render('article_kind/articleKindNew.html.twig', [
            'articleKindForm' => $form->createView()
        ]);
    }

        #[Route('Kind/{id}/edit', name: 'articleKind_edit')]
        public function articleKindEdit($id, ArticleKindRepository $articleKindRepository, Request $request, EntityManagerInterface $entityManager){
            if (!$this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_main');
            }
            $articleKind = $articleKindRepository->findOneBy([
                'id' => $id
            ]);

            if(!$articleKind){
                $this->addFlash('warning', 'No type found');

                return $this->redirectToRoute('article_kind_listing');

            }
            $form = $this->createForm(ArticleKindType::class, $articleKind);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $bookKindToSave = $form->getData();
                $entityManager->persist($bookKindToSave);
                $entityManager->flush();
                $this->addFlash('success', 'Your type edited successfully');

                return $this->redirectToRoute('article_kind_listing');
            }
            return $this->render('article_kind/articleKindEdit.html.twig',[
                'articleKindForm' => $form->createView()
            ]);
        }

    #[Route('/Kind/{id}/delete', name: 'articleKind_delete')]
    public function articleKindDelete($id, ArticleKindRepository $articleKindRepository, EntityManagerInterface $entityManager){
        // Vérifie si l'utilisateur a le ROLE_ADMIN
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_main');
        }
        $articleKind = $articleKindRepository->findOneBy([
            'id' => $id
        ]);
        // Prépare la requête pour supprimer le genre de la DB
        $entityManager->remove($articleKind);
        $entityManager->flush();

        $this->addFlash('success', 'Your type deleted successfully');
        return $this->redirectToRoute('article_kind_listing');
    }


}
