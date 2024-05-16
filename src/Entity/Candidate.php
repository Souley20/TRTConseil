<?php

namespace App\Entity;

use App\Repository\CandidateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

# [ORM\Entity(repositoryClass: CandidateRepository::class)]
class Candidate implements UserInterface, PasswordAuthenticatedUserInterface
{
    # [ORM\Id]
    # [ORM\GeneratedValue]
    # [ORM\Column(type: 'integer')]
    private int $id;

    # [ORM\Column(type: 'string', length: 180, unique: true)]
    private string $email;

    # [ORM\Column(type: 'json')]
    private array $roles = [];

    # [ORM\Column(type: 'string')]
    private string $password;

    # [ORM\Column(type: 'string', length: 30, nullable: true)]
    private string $firstname;

    # [ORM\Column(type: 'string', length: 30, nullable: true)]
    private string  $lastname;

    # [ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $cv;

    # [ORM\Column(type: 'boolean')]
    private bool $isValid = false;

    // #[ORM\ManyToMany(targetEntity: JobOffer::class, mappedBy: 'candidate')]
    // private Collection $jobOffers;

    # [ORM\Column(type: 'string', length: 50, nullable: true)]
    private $job;

    # [ORM\OneToMany(mappedBy: 'candidate', targetEntity: Candidacy::class)]
    private $candidacies;

    # [Pure] public function __construct()
    {
        // $this->jobOffers = new ArrayCollection();
        $this->candidacies = new ArrayCollection();
    }

    /**
     * Transform to string in Candidacy, validate-candidacy.html.twig
     * 
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getId();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCv()
    {
        return $this->cv;
    }

    public function setCv($cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }

    // /**
    //  * @return Collection<int, JobOffer>
    //  */
    // public function getJobOffers(): Collection
    // {
    //     return $this->jobOffers;
    // }

    // public function addJobOffer(JobOffer $jobOffer): self
    // {
    //     if (!$this->jobOffers->contains($jobOffer)) {
    //         $this->jobOffers[] = $jobOffer;
    //         $jobOffer->addCandidate($this);
    //     }

    //     return $this;
    // }

    // public function removeJobOffer(JobOffer $jobOffer): self
    // {
    //     if ($this->jobOffers->removeElement($jobOffer)) {
    //         $jobOffer->removeCandidate($this);
    //     }

    //     return $this;
    // }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(string $job): self
    {
        $this->job = $job;

        return $this;
    }

    /**
     * @return Collection<int, Candidacy>
     */
    public function getCandidacies(): Collection
    {
        return $this->candidacies;
    }

    public function addCandidacy(Candidacy $candidacy): self
    {
        if (!$this->candidacies->contains($candidacy)) {
            $this->candidacies[] = $candidacy;
            $candidacy->setCandidate($this);
        }

        return $this;
    }

    public function removeCandidacy(Candidacy $candidacy): self
    {
        if ($this->candidacies->removeElement($candidacy)) {
            // set the owning side to null (unless already changed)
            if ($candidacy->getCandidate() === $this) {
                $candidacy->setCandidate(null);
            }
        }

        return $this;
    }
}
