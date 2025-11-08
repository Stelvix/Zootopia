<?php

namespace App\Entity;

use App\Repository\EnclosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: EnclosRepository::class)]
class Enclos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'enclos')]
    private ?Espace $espace = null;

    #[Assert\NotBlank(message: 'Le nom de l\'enclos ne peut pas être vide.')]
    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[Assert\Positive(message: 'La superficie doit être un nombre positif.')]
    #[Assert\NotNull(message: 'La superficie ne peut pas être nulle.')]
    #[ORM\Column]
    private ?float $Superficie = null;

    #[Assert\Positive(message: 'La capacité maximale doit être un nombre positif.')]
    #[Assert\NotNull(message: 'La capacité maximale ne peut pas être nulle.')]
    #[ORM\Column]
    private ?int $CapaciteMax = null;

    /**
     * @var Collection<int, Animaux>
     */
    #[ORM\OneToMany(targetEntity: Animaux::class, mappedBy: 'enclos')]
    private Collection $animauxes;

    public function __construct()
    {
        $this->animauxes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEspace(): ?Espace
    {
        return $this->espace;
    }

    public function setEspace(?Espace $espace): static
    {
        $this->espace = $espace;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getSuperficie(): ?float
    {
        return $this->Superficie;
    }

    public function setSuperficie(float $Superficie): static
    {
        $this->Superficie = $Superficie;

        return $this;
    }

    public function getCapaciteMax(): ?int
    {
        return $this->CapaciteMax;
    }

    public function setCapaciteMax(int $CapaciteMax): static
    {
        $this->CapaciteMax = $CapaciteMax;

        return $this;
    }

    /**
     * @return Collection<int, Animaux>
     */
    public function getAnimauxes(): Collection
    {
        return $this->animauxes;
    }

    public function addAnimaux(Animaux $animaux): static
    {

if ($this->animauxes->count() >= $this->CapaciteMax) {
        throw new \Exception('Capacité maximale de l\'enclos atteinte.');
    }

        if (!$this->animauxes->contains($animaux)) {
            $this->animauxes->add($animaux);
            $animaux->setEnclos($this);
        }

        return $this;
    }

    public function removeAnimaux(Animaux $animaux): static
    {
        if ($this->animauxes->removeElement($animaux)) {
            // set the owning side to null (unless already changed)
            if ($animaux->getEnclos() === $this) {
                $animaux->setEnclos(null);
            }
        }

        return $this;
    }



}
