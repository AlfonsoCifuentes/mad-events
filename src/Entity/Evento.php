<?php

namespace App\Entity;

use App\Repository\EventoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventoRepository::class)]
class Evento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    #[ORM\Column(type: 'text')]
    private $text;

    #[ORM\Column(type: 'string', length: 255)]
    private $ubication;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'eventos')]
    public $Usuario;

    public function __construct()
    {
        $this->Usuario = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getUbication(): ?string
    {
        return $this->ubication;
    }

    public function setUbication(string $ubication): self
    {
        $this->ubication = $ubication;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }


    public function __toString()
    {
        return $this->Usuario;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsuario(): Collection
    {
        return $this->Usuario;
    }

    public function getEventos(): Collection
    {
        return $this->Evento;
    }

    public function listAllEventos(): Collection
    {
        return $this->Evento;
    }

    public function addUsuario(User $usuario): self
    {
        if (!$this->Usuario->contains($usuario)) {
            $this->Usuario[] = $usuario;
        }

        return $this;
    }

    public function removeUsuario(User $usuario): self
    {
        $this->Usuario->removeElement($usuario);

        return $this;
    }
}
