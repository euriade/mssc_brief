<?php

namespace App\Entity;

use App\Entity\Brief;
use App\Repository\WebsiteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebsiteRepository::class)]
class Website
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $front_access = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $back_access = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $login = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password = null;

    #[ORM\ManyToOne(targetEntity: Brief::class, inversedBy: 'website')]
    private $brief;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFrontAccess(): ?string
    {
        return $this->front_access;
    }

    public function setFrontAccess(?string $front_access): self
    {
        $this->front_access = $front_access;

        return $this;
    }

    public function getBackAccess(): ?string
    {
        return $this->back_access;
    }

    public function setBackAccess(?string $back_access): self
    {
        $this->back_access = $back_access;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(?string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getBrief(): ?Brief
    {
        return $this->brief;
    }

    public function setBrief(?Brief $brief): self
    {
        $this->brief = $brief;

        return $this;
    }

    public function __toString()
    {
        return "cc";
    }
}
