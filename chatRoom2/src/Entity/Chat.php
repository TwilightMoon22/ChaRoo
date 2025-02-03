<?php

namespace App\Entity;

use App\Repository\ChatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChatRepository::class)]
class Chat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'chat', targetEntity: Message::class)]
    private Collection $messages;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToOne(mappedBy: 'chat', cascade: ['persist', 'remove'])]
    private ?Participantes $participantes = null;


    public function __construct()
    {
        $this->messages = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setChat($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getChat() === $this) {
                $message->setChat(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Participantes>
     */
    public function getParticipantes(): Collection
    {
        return $this->participantes;
    }

    public function addParticipante(Participantes $participante): static
    {
        if (!$this->participantes->contains($participante)) {
            $this->participantes->add($participante);
            $participante->addChat($this);
        }

        return $this;
    }

    public function removeParticipante(Participantes $participante): static
    {
        if ($this->participantes->removeElement($participante)) {
            $participante->removeChat($this);
        }

        return $this;
    }

    public function setParticipantes(Participantes $participantes): static
    {
        // set the owning side of the relation if necessary
        if ($participantes->getChat() !== $this) {
            $participantes->setChat($this);
        }

        $this->participantes = $participantes;

        return $this;
    }
}
