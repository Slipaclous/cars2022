<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

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
    private ?string $link_img = null;

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
        return $this->link_img;
    }

    public function setLinkImg(?string $link_img): self
    {
        $this->link_img = $link_img;

        return $this;
    }
}
