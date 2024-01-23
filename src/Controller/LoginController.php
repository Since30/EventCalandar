<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\LoginFormType;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home'); 
        }
        // // Créer et gérer le formulaire de connexion
        $form = $this->createForm(LoginFormType::class);
        // $form->handleRequest($request);

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastEmail = $authenticationUtils->getLastUsername();

        // if ($form->isSubmitted() && $form->isValid()) {
        //     return $this->redirectToRoute('app_home'); 
        // }

        // Rendre la vue avec le formulaire et les éventuelles erreurs d'authentification
        return $this->render('login/index.html.twig', [
            'form' => $form->createView(),
            'last_username' => $lastEmail,
            'error' => $error,
        ]);
    }
}
