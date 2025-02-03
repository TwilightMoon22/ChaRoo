<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Entity\Message;
use App\Entity\Participantes;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/message')]
class MessageController extends AbstractController
{
    #[Route('/', name: 'app_message_index', methods: ['GET'])]
    public function index(MessageRepository $messageRepository): Response
    {
        return $this->render('message/index.html.twig', [
            'messages' => $messageRepository->findAll(),
        ]);
    }

    #[Route('/new/{chat_id}', name: 'app_message_new', methods: ['POST', 'GET'])]
    public function new(Request $request, EntityManagerInterface $entityManager, $chat_id): Response
    {
        // Encuentra el chat por ID
        $chat = $entityManager->getRepository(Chat::class)->find($chat_id);
    
        // Si el chat no existe, muestra un error
        if (!$chat) {
            throw $this->createNotFoundException('Chat no encontrado');
        }
    
        // Crear un nuevo mensaje
        $message = new Message();
        
        // Obtén el texto del mensaje desde el formulario
        $message->setText($request->request->get('name')); // Aquí tomamos el campo 'name' del formulario
        $message->setChat($chat); // Asociamos el chat con el mensaje
        $message->setUser($this->getUser()); // Asociamos el usuario autenticado
        $message->setDate(new \DateTime()); // Establecemos la fecha y hora actual del mensaje
    
        // Persistir el mensaje en la base de datos
        $entityManager->persist($message);
        $entityManager->flush();
    
        // Verificar si el usuario ya es un participante en el chat
        $participanteRepository = $entityManager->getRepository(Participantes::class);
        
        // Buscar un participante con la misma combinación de chat y usuario
        $existingParticipant = $participanteRepository->findOneBy([
            'chat' => $chat,
            'user' => $this->getUser()
        ]);
    
        // Si no existe, creamos un nuevo participante
        if (!$existingParticipant) {
            $participante = new Participantes();
            $participante->setChat($chat);
            $participante->setUser($this->getUser());
    
            // Persistimos el nuevo participante
            $entityManager->persist($participante);
            $entityManager->flush();
        }
    
        // Redirigir al mismo chat para que el usuario vea el nuevo mensaje
        return $this->redirectToRoute('app_chat_show', ['id' => $chat->getId()]);
    }
    

    

    #[Route('/{id}', name: 'app_message_show', methods: ['GET'])]
    public function show(Message $message): Response
    {
        return $this->render('message/show.html.twig', [
            'message' => $message,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_message_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Message $message, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('message/edit.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_message_delete', methods: ['POST'])]
    public function delete(Request $request, Message $message, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_message_index', [], Response::HTTP_SEE_OTHER);
    }
}
