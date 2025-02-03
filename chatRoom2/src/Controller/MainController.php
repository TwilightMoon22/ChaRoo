<?php
  namespace App\Controller;

  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\Routing\Annotation\Route;
  
  class MainController extends AbstractController
  {
      #[Route('/', name: 'app_login_redirect')]
      public function loginRedirect(): Response
      {
          // Verifica si el usuario está autenticado
          if ($this->getUser()) {
              // Redirige a la página de chats o la ruta que elijas
              return $this->redirectToRoute('app_chat_index'); // Cambia a la ruta que desees
          }
  
          // Si el usuario no está autenticado, redirige al login
          return $this->redirectToRoute('app_login'); // Si no está logueado, lo rediriges al login
      }
  }
  
?>