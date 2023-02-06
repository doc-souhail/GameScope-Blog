<?php

namespace App\Controller;

use App\Entity\Main;
use App\Form\ArticleSearchForm;
use App\Form\ArticlesType;
use App\Repository\MainRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


// AbstractController class qui nous donne des services comme la services de securite et de gestion de twig //
class MainController extends AbstractController
{
    ////////////////////////////////////////////////////////////////////
    //////////////////////////// MAIN APP ARTICLES LISTING ///////////////////////

    #[Route('/', name: 'app_main')]
    public function articles(MainRepository $mainRepository, Request $request): Response
    {
        $form = $this->createForm(ArticleSearchForm::class);


        $form->handleRequest($request);
        $searchFormValue = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $searchFormValue = $form->getData();
        }
        $articles = $mainRepository->findArticleByTitle($searchFormValue);

        return $this->render('main/index.html.twig', [
            'articles' => $articles,
            'searchForm' => $form->createView()
        ]);
    }

    ////////////////////////////////////////////////////////////////////
    //////////////////////////// ARTICLES NEW /////////////////////////
    ///
    // you need to use first the home/new before home/{id} or its gona be a error and url like home/{id}/new and thats not coool
    #[Route('/home/new', name: 'articles_new')]
    public function articlesNew(Request $request, EntityManagerInterface $entityManager)
    {
        $article = new Main();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $articleToSave = $form
                ->getData()
                ->setUser($user)->setPosted(new DateTime());
            $entityManager->persist($articleToSave);
            $entityManager->flush();
            $this->addFlash('success', 'Your article added successfully');
            return $this->redirectToRoute('app_main');
        }
        return $this->render('main/articlesNew.html.twig', [
            'articleForm' => $form->createView()
        ]);
    }

    ////////////////////////////////////////////////////////////////////
    //////////////////////////// ARTICLES EDIT /////////////////////////

    #[Route('/home/{id}/edit', name: 'article_edit')]
    public function articlesEdit($id, MainRepository $mainRepository, Request $request, EntityManagerInterface $entityManager)
    {

        $articles = $mainRepository->findOneBy([
            'id' => $id
        ]);
        $user = $this->getUser();

        if (!$articles) {
            return $this->redirectToRoute('app_main');
        }
        if (!$user) {
            return $this->redirectToRoute('app_main');
        }
        if ($user != $articles->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_main');
        }
        $form = $this->createForm(ArticlesType::class, $articles);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleToSave = $form->getData();
            $entityManager->persist($articleToSave);
            $entityManager->flush();

            $this->addFlash('success', 'Your article edited successfully');
            return $this->redirectToRoute('app_main');
        }
        return $this->render('main/articlesEdit.html.twig', [
            'articleForm' => $form->createView()

        ]);
    }

    ////////////////////////////////////////////////////////////////////
    //////////////////////////// ARTICLES DELETE ///////////////////////

    #[Route('/home/{id}/delete', name: 'article_delete')]
    public function bookDelete($id, MainRepository $mainRepository, EntityManagerInterface $entityManager)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $articles = $mainRepository->findOneBy([
            'id' => $id
        ]);

        $entityManager->remove($articles);
        $entityManager->flush();

        $this->addFlash('success', 'Your article successfully deleted.');

        return $this->redirectToRoute('app_main');
    }

    ////////////////////////////////////////////////////////////////////
    //////////////////////////// ARTICLES DETAIL ///////////////////////


    //    route for detail page with each article id in the url
    #[Route('/home/{id}', name: 'articles_detail')]
    public function articlesDetail($id, MainRepository $mainRepository)
    {
        $articles = $mainRepository->findOneBy([
            'id' => $id
        ]);
        if (!$articles) {
            $this->addFlash('warning', 'Article not found'); {
                return $this->redirectToRoute('app_main');
            }
        }
        return $this->render('main/articlesDetail.html.twig', [
            'articles' => $articles
        ]);
    }
}
