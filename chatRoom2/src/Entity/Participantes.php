<?php

namespace App\Entity;

use App\Repository\ParticipantesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipantesRepository::class)]
#[ORM\Table(name: 'participantes')]
class Participantes
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Chat::class)]
    #[ORM\JoinColumn(name: 'chat_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Chat $chat = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getChat(): ?Chat
    {
        return $this->chat;
    }

    public function setChat(Chat $chat): static
    {
        $this->chat = $chat;
        return $this;
    }
}
