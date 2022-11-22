<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use App\Repository\VoituresRepository;
use App\Entity\Marques;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VoituresRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Voitures
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'voitures')]
    private ?Marques $marque = null;

    #[ORM\Column(length: 120)]
    #[Assert\Length(min: 5, max: 110, minMessage: "Le modèle doit faire plus de 5 caractères", maxMessage:"Le modèlen ne doit pas faire plus de 120 caractères")]
    private ?string $modele = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;


    #[ORM\Column]
    // #[Assert\Length(min: 20, max: 110, minMessage: "L'introduction doit faire plus de 20 caractères", maxMessage:"L'introduction ne doit pas faire plus de 255 caractères")]
    private ?int $km = null;

    #[ORM\Column]
    
    private ?float $prix = null;

    #[ORM\Column]
    
    private ?float $cylindree = null;

    #[ORM\Column]
  
    private ?int $puissance = null;

    #[ORM\Column(length: 120)]
    private ?string $carburant = null;

    #[ORM\Column(length: 120)]
    private ?string $transmission = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $annee_circulation = null;

    #[ORM\Column]
    private ?int $nb_proprio = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(min: 100, minMessage:"Votre description doit faire plus de 100 caractères")]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $option_car = null;

    #[ORM\OneToMany(mappedBy: 'voitures', targetEntity: Images::class, cascade:['persist'])]
    private Collection $images;

    #[ORM\Column(length: 255)]
    private ?string $coverImg = null;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function initializeSlug() :void
    {
        if(empty($this->slug))
        {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->modele.'-'.rand(2000,8000000));
        }
    }
    // public function __toString()
    // {
    //     return $this -> modele;
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?Marques
    {
        return $this->marque;
    }

    public function setMarque(?Marques $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
    public function getKm(): ?int
    {
        return $this->km;
    }

    public function setKm(int $km): self
    {
        $this->km = $km;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCylindree(): ?int
    {
        return $this->cylindree;
    }

    public function setCylindree(int $cylindree): self
    {
        $this->cylindree = $cylindree;

        return $this;
    }

    public function getPuissance(): ?int
    {
        return $this->puissance;
    }

    public function setPuissance(int $puissance): self
    {
        $this->puissance = $puissance;

        return $this;
    }

    public function getCarburant(): ?string
    {
        return $this->carburant;
    }

    public function setCarburant(string $carburant): self
    {
        $this->carburant = $carburant;

        return $this;
    }

    public function getTransmission(): ?string
    {
        return $this->transmission;
    }

    public function setTransmission(string $transmission): self
    {
        $this->transmission = $transmission;

        return $this;
    }

    public function getAnneeCirculation(): ?\DateTimeInterface
    {
        return $this->annee_circulation;
    }

    public function setAnneeCirculation(\DateTimeInterface $annee_circulation): self
    {
        $this->annee_circulation = $annee_circulation;

        return $this;
    }

    public function getNbProprio(): ?int
    {
        return $this->nb_proprio;
    }

    public function setNbProprio(int $nb_proprio): self
    {
        $this->nb_proprio = $nb_proprio;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOptionCar(): ?string
    {
        return $this->option_car;
    }

    public function setOptionCar(?string $option_car): self
    {
        $this->option_car = $option_car;

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setVoitures($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getVoitures() === $this) {
                $image->setVoitures(null);
            }
        }

        return $this;
    }

    public function getCoverImg(): ?string
    {
        return $this->coverImg;
    }

    public function setCoverImg(string $coverImg): self
    {
        $this->coverImg = $coverImg;

        return $this;
    }
}
