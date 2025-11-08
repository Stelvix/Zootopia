<?php

namespace App\Entity;

use App\Repository\AnimauxRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: AnimauxRepository::class)]


class Animaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Regex(pattern: '/^\d{14}$/', message: 'Le numéro d\'identification doit contenir exactement 14 chiffres.')]
    #[ORM\Column(length: 14)]
    private ?string $Numero_identification = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Nom = null;

    #[Assert\LessThanOrEqual(
        propertyPath: 'Date_Arrivee_au_zoo',
        message: 'La date de naissance doit être antérieure ou égale à la date d\'arrivée au zoo.'
    )]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $Date_naissance = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $Date_Arrivee_au_zoo = null;

    #[Assert\GreaterThanOrEqual(
        propertyPath: 'Date_Arrivee_au_zoo',
        message: 'La date de départ du zoo doit être postérieure ou égale à la date d\'arrivée au zoo.'
    )]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $Date_de_Depart_du_zoo = null;

    #[ORM\Column]
    private ?bool $le_zoo_en_es_proprietaire = null;

    #[ORM\Column(length: 50)]
    private ?string $Genre = null;

    #[ORM\Column(length: 50)]
    private ?string $Espece = null;

    #[ORM\Column(length: 255)]
    private ?string $Sexe = null;

    #[ORM\Column]
    private ?bool $Sterilise = null;

    #[ORM\Column(nullable: true)]
    private ?bool $EsEnQuarantaine = null;

    #[ORM\ManyToOne(inversedBy: 'animauxes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Enclos $enclos = null;


    public function __construct()
    {
        // Initialise la date d'arrivée par défaut à aujourd'hui
        $this->Date_Arrivee_au_zoo = new \DateTime('today');
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroIdentification(): ?string
    {
        return $this->Numero_identification;
    }

    public function setNumeroIdentification(string $Numero_identification): static
    {
        $this->Numero_identification = $Numero_identification;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(?string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }


    public function getDateNaissance(): ?\DateTime
    {
        return $this->Date_naissance;
    }

    public function setDateNaissance(?\DateTime $Date_naissance): static
    {
        $this->Date_naissance = $Date_naissance;

        return $this;
    }

    public function getDateArriveeAuZoo(): ?\DateTime
    {
        return $this->Date_Arrivee_au_zoo ;
    }

    public function setDateArriveeAuZoo(\DateTime $Date_Arrivee_au_zoo): static
    {
        $this->Date_Arrivee_au_zoo = $Date_Arrivee_au_zoo;

        return $this;
    }

    public function getDateDeDepartDuZoo(): ?\DateTime
    {
        return $this->Date_de_Depart_du_zoo;
    }

    public function setDateDeDepartDuZoo(?\DateTime $Date_de_Depart_du_zoo): static
    {
        $this->Date_de_Depart_du_zoo = $Date_de_Depart_du_zoo;

        return $this;
    }

    public function isLeZooEnEsProprietaire(): ?bool
    {
        return $this->le_zoo_en_es_proprietaire;
    }

    public function setLeZooEnEsProprietaire(bool $le_zoo_en_es_proprietaire): static
    {
        $this->le_zoo_en_es_proprietaire = $le_zoo_en_es_proprietaire;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->Genre;
    }

    public function setGenre(string $Genre): static
    {
        $this->Genre = $Genre;

        return $this;
    }

    public function getEspece(): ?string
    {
        return $this->Espece;
    }

    public function setEspece(string $Espece): static
    {
        $this->Espece = $Espece;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->Sexe;
    }

    public function setSexe(string $Sexe): static
    {
        $this->Sexe = $Sexe;

        return $this;
    }

    public function isSterilise(): ?bool
    {
        return $this->Sterilise;
    }

    public function setSterilise(bool $Sterilise): static
    {
        $this->Sterilise = $Sterilise;

        return $this;
    }

    public function isEsEnQuarantaine(): ?bool
    {
        return $this->EsEnQuarantaine;
    }

    public function setEsEnQuarantaine(?bool $EsEnQuarantaine): static
    {
        $this->EsEnQuarantaine = $EsEnQuarantaine;

        return $this;
    }

    public function getEnclos(): ?Enclos
    {
        return $this->enclos;
    }

    public function setEnclos(?Enclos $enclos): static
    {
        $this->enclos = $enclos;

        return $this;
    }
}
