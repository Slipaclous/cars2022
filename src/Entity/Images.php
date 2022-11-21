<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?voitures $voitures = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Url(message: "Veuillez rendre une URL valide")]
    private ?string $linkImg = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVoitures(): ?voitures
    {
        return $this->voitures;
    }

    public function setVoitures(?voitures $voitures): self
    {
        $this->voitures = $voitures;

        return $this;
    }

    public function getLinkImg(): ?string
    {
        return $this->linkImg;
    }

    public function setLinkImg(?string $linkImg): self
    {
        $this->linkImg = $linkImg;

        return $this;
    }
}
