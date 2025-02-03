<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Entity\Message;
use App\Entity\Participantes;
use App\Form\ChatType;
use App\Repository\ChatRepository;
use App\Repository\ParticipantesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ChatController extends AbstractController
{
    #[Route('/chat', name: 'app_chat_index', methods: ['GET'])]
    public function index(ChatRepository $chatRepository, EntityManagerInterface $entityManager): Response
    {
        // Use QueryBuilder to join the Participant table and filter chats that have at least one participant
        $queryBuilder = $entityManager->getRepository(Chat::class)
            ->createQueryBuilder('c')
            ->innerJoin('c.participantes', 'p')  // Join the Participant table
            ->groupBy('c.id');  // Group by chat to ensure distinct chats
    
        // Execute the query to get the chats with participants
        $chats = $queryBuilder->getQuery()->getResult();
    
        return $this->render('chat/index.html.twig', [
            'chats' => $chats,
        ]);
    }
    
    
    #[Route('/chat/new', name: 'app_chat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $chat = new Chat();
        $participante = new Participantes();
        $participante->setChat($chat);
        $participante->setUser($this->getUser());
        $form = $this->createForm(ChatType::class, $chat);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($chat);
            $entityManager->persist($participante);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_chat_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('chat/new.html.twig', [
            'chat' => $chat,
            'form' => $form,
        ]);
    }
    


    #[Route('/chat/show/{id}', name: 'app_chat_show', methods: ['GET'])]
    public function show($id, EntityManagerInterface $entityManager, Chat $chat): Response
    {
        // Encuentra el chat por ID
        $chat = $entityManager->getRepository(Chat::class)->find($id);

        // Si el chat no existe, muestra un error
        if (!$chat) {
            throw $this->createNotFoundException('Chat no encontrado');
        }

        // Obtener los mensajes relacionados con este chat
        $messages = $entityManager->getRepository(Message::class)
                                ->findBy(['chat' => $chat], ['date' => 'ASC']);

        // Pasar los mensajes a la vista
        return $this->render('chat/show.html.twig', [
            'chat' => $chat,
            'messages' => $messages,
        ]);
    }

   #[Route('/chat/exit/{id}', name: 'app_chat_exit', methods: ['GET'])]
public function exit($id, EntityManagerInterface $entityManager, Chat $chat, ParticipantesRepository $participanteRepository, ChatRepository $chatRepository): Response
{
    // Obtener el chat por su ID
    $chat = $entityManager->getRepository(Chat::class)->find($id);
    if (!$chat) {
        // Si no se encuentra el chat, retornar un error
        throw $this->createNotFoundException('Chat no encontrado');
    }

    // Suponiendo que el usuario que llama a esta función está logueado, podemos obtener su ID de la sesión o token
    $user = $this->getUser(); // Esto depende de tu sistema de autenticación

    if (!$user) {
        // Si el usuario no está autenticado, redirigir o retornar error
        return $this->redirectToRoute('app_login');
    }

    // Buscar el participante en la tabla de participantes
    $participant = $participanteRepository->findOneBy([
        'chat' => $chat,
        'user' => $user
    ]);

    if (!$participant) {
        // Si no se encuentra el participante, redirigir o retornar error
        throw $this->createNotFoundException('Participante no encontrado');
    }

    // Eliminar la relación de participante
    $entityManager->remove($participant);
    $entityManager->flush();

    // Redirigir a la página de chats (app_chat_index)
    return $this->redirectToRoute('app_chat_index'); // Redirigir a la lista de chats
}

    
    #[Route('/chat/{id}/edit', name: 'app_chat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chat $chat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChatType::class, $chat);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('app_chat_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('chat/edit.html.twig', [
            'chat' => $chat,
            'form' => $form,
        ]);
    }
    
    #[Route('/chat/{id}', name: 'app_chat_delete', methods: ['POST'])]
    public function delete(Request $request, Chat $chat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($chat);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('app_chat_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
