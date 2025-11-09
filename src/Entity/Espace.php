<?php

namespace App\Entity;

use App\Repository\EspaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: EspaceRepository::class)]
class Espace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column]
    private ?float $superficie = null;

    #[Assert\LessThanOrEqual(
        propertyPath: 'Date_fermeture',
        message: 'La date d\'ouverture doit être antérieure ou égale à la date de fermeture.'
    )]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $Date_ouverture = null;

    #[Assert\GreaterThan(
        propertyPath: 'Date_ouverture',
        message: 'La date de fermeture doit être postérieure à la date d\'ouverture.'
    )]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $Date_fermeture = null;

    /**
     * @var Collection<int, Enclos>
     */
    #[ORM\OneToMany(targetEntity: Enclos::class, mappedBy: 'espace')]
    private Collection $enclos;

    public function __construct()
    {
        $this->enclos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
        return $this->superficie;
    }

    public function setSuperficie(float $superficie): static
    {
        $this->superficie = $superficie;

        return $this;
    }

    public function getDateOuverture(): ?\DateTime
    {
        return $this->Date_ouverture;
    }

    public function setDateOuverture(?\DateTime $Date_ouverture): static
    {
        $this->Date_ouverture = $Date_ouverture;

        return $this;
    }

    public function getDateFermeture(): ?\DateTime
    {
        return $this->Date_fermeture;
    }

    public function setDateFermeture(?\DateTime $Date_fermeture): static
    {


       $this->Date_fermeture = $Date_fermeture;

               return $this;

    }

    /**
     * @return Collection<int, Enclos>
     */
    public function getEnclos(): Collection
    {
        return $this->enclos;
    }

    public function addEnclo(Enclos $enclo): static
    {
        if (!$this->enclos->contains($enclo)) {
            $this->enclos->add($enclo);
            $enclo->setEspace($this);
        }

        return $this;
    }

    public function removeEnclo(Enclos $enclo): static
    {
        if ($this->enclos->removeElement($enclo)) {
            // set the owning side to null (unless already changed)
            if ($enclo->getEspace() === $this) {
                $enclo->setEspace(null);
            }
        }

        return $this;
    }

#[Assert\Callback]
public function validationDates(ExecutionContextInterface $context): void
{
    if ($this->Date_fermeture !== null && $this->Date_ouverture === null) {
        $context->buildViolation('Veuillez renseigner la date d\'ouverture avant de définir une date de fermeture.')
            ->atPath('Date_fermeture')
            ->addViolation();
    }
}


}
