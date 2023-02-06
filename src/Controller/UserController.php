<?php

namespace App\Controller;

use App\Form\ProfileType;
use App\Form\UserType;
use App\Repository\UserRepository;
//use Cassandra\Type\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
//    USERS LISTING
    #[Route('/user', name: 'app_user')]

    public function userListing(UserRepository $userRepository): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }
        $users = $userRepository->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'controller_name' => 'UserController',
        ]);
    }
    //    USERS DELETE
    #[Route('/users/{id}/delete', name: 'user_delete')]
    public function userDelete(UserRepository $userRepository, EntityManagerInterface $entityManager, $id){
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }
        $user = $userRepository->findOneBy(['id' => $id]);
        if (!$user){
            return $this->redirectToRoute('app_user');
        }
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('app_user');
    }

//    USERS Edit
    #[Route('/users/{id}/edit', name: 'user_edit')]
    public function userEdit($id, UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\RedirectResponse|Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_main');
        }
        $user = $userRepository->findOneBy(['id' => $id]);
        if (!$user) {
            return $this->redirectToRoute('app_user');
        }
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/userEdit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
//    PROFIL Edit
    #[Route('/profile/edit', name: 'profile_edit')]
    public function editProfile(Request $request, EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\RedirectResponse|Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_main');
        }

        $form = $this->createForm(ProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('user/profileEdit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);

    }

}
