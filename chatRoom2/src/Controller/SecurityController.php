<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Si el usuario ya está autenticado, redirigir directamente a la ruta '/chat'
        if ($this->getUser()) {
            return $this->redirectToRoute('app_chat_index'); // Redirige a la ruta de los chats
        }

        // Obtener el error de autenticación, si existe
        $error = $authenticationUtils->getLastAuthenticationError();
        // Obtener el último nombre de usuario ingresado
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Esta función es interceptada por Symfony automáticamente
        // cuando se hace logout, no es necesario que hagas nada aquí
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
