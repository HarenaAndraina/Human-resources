<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\DateType;
use Doctrine\DBAL\Types\Types;
use App\Entity\Conge\DemandeConge;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Utilisateur extends AbstractPartiePrenante implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 18, scale: 2)]
    private ?string $salaire = null;

    #[ORM\ManyToOne(inversedBy: 'utilisateurs',)]
    #[ORM\JoinColumn(name: "id_departement", nullable: false)]
    private ?Departement $departement = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "id_poste", nullable: false)]
    private ?Poste $poste = null;

    #[ORM\OneToOne(inversedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: "id_contrat", nullable: false)]
    private ?Contrat $contrat = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $debutActivite = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var Collection<int, DemandeConge>
     */
    #[ORM\OneToMany(targetEntity: DemandeConge::class, mappedBy: 'id_utilisateur')]
    private Collection $demandeConges;

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getSalaire(): ?string
    {
        return $this->salaire;
    }

    public function setSalaire(string $salaire): static
    {
        $this->salaire = $salaire;

        return $this;
    }


    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): static
    {
        $this->departement = $departement;

        return $this;
    }

    public function getPoste(): ?Poste
    {
        return $this->poste;
    }

    public function setPoste(?Poste $poste): static
    {
        $this->poste = $poste;

        return $this;
    }

    public function getContrat(): ?Contrat
    {
        return $this->contrat;
    }

    public function setContrat(Contrat $contrat): static
    {
        $this->contrat = $contrat;

        return $this;
    }

    public function getDebutActivite(): ?DateTimeInterface
    {
        return $this->debutActivite;
    }

    public function setDebutActivite(DateTimeInterface $debut_activite): static
    {
        $this->debutActivite = $debut_activite;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }


    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }


    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function __construct(string $id="")
    {
        $this->id = $id;
        $this->demandeConges = new ArrayCollection();
    }

    public function getPrefix(): string
    {
        return "UTI";
    }

    public function getSequenceName(): string
    {
        return "id_utilisateur_seq";
    }

    /**
     * @return Collection<int, DemandeConge>
     */
    public function getDemandeConges(): Collection
    {
        return $this->demandeConges;
    }

    public function addDemandeConge(DemandeConge $demandeConge): static
    {
        if (!$this->demandeConges->contains($demandeConge)) {
            $this->demandeConges->add($demandeConge);
            $demandeConge->setUtilisateur($this);
        }

        return $this;
    }

    public function removeDemandeConge(DemandeConge $demandeConge): static
    {
        if ($this->demandeConges->removeElement($demandeConge)) {
            // set the owning side to null (unless already changed)
            if ($demandeConge->getUtilisateur() === $this) {
                $demandeConge->setUtilisateur(null);
            }
        }

        return $this;
    }
}
