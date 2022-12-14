<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * Permet à l'utilisateur de se connecter
     *
     * @param AuthenticationUtils $utils
     * @return Response
     */
    #[Route('/login', name: 'account_login')]
    public function index(AuthenticationUtils $utils): Response
    {
          // Prend l'erreur s'il y en a une 
+         $error = $utils->getLastAuthenticationError();
          $username = $utils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }
    /**
     * Permet à l'utilisateur de se déconnecter
     *
     * @return void
     */
    #[Route("/logout", name:"account_logout")]
    public function logout(): void
    {
        // ..
    }

}
