<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private string $title;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $start;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $end;

    #[ORM\ManyToOne(inversedBy: 'tasks', targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

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

public function getStart(): ?\DateTimeInterface
{
    return $this->start;
}

public function setStart(\DateTimeInterface $start): self
{
    $this->start = $start;
    return $this;
}

public function getEnd(): ?\DateTimeInterface
{
    return $this->end;
}

public function setEnd(\DateTimeInterface $end): self
{
    $this->end = $end;
    return $this;
}

public function getUser(): ?User
{
    return $this->user;
}

public function setUser(?User $user): self
{
    $this->user = $user;
    return $this;
}
}
