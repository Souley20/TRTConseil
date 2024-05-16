<?php

namespace App\Entity;

use App\Repository\JobOfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

# [ORM\Entity(repositoryClass: JobOfferRepository::class)]
class JobOffer
{
    # [ORM\Id]
    # [ORM\GeneratedValue]
    # [ORM\Column(type: 'integer')]
    private int  $id;

    # [ORM\Column(type: 'string', length: 30)]
    private string $jobTitle;

    # [ORM\Column(type: 'string', length: 100)]
    private string $workplace;

    # [ORM\Column(type: 'text')]
    private string $description;

    # [ORM\Column(type: 'boolean')]
    private bool $isValid = false;

    # [ORM\ManyToOne(targetEntity: Consultant::class, inversedBy: 'jobOffers')]
    // #[ORM\JoinColumn(nullable: true)]
    private ?Consultant $consultant;

    # [ORM\ManyToOne(targetEntity: Recruiter::class, inversedBy: 'jobOffers')]
    // #[ORM\JoinColumn(nullable: true)]
    private ?Recruiter $recruiter;

    # [ORM\Column(type: 'integer')]
    private int $salary;

    # [ORM\Column(type: 'integer')]
    private int $schedule;

    # [ORM\OneToMany(mappedBy: 'jobOffer', targetEntity: Candidacy::class)]
    private $candidacies;

    #[Pure] public function __construct()
    {
        $this->candidate = new ArrayCollection();
        $this->candidacies = new ArrayCollection();
    }

    /**
     * Transform to string function to template
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

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(string $jobTitle): self
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function getWorkplace(): ?string
    {
        return $this->workplace;
    }

    public function setWorkplace(string $workplace): self
    {
        $this->workplace = $workplace;

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

    public function isIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function getConsultant(): ?Consultant
    {
        return $this->consultant;
    }

    public function setConsultant(?Consultant $consultant): self
    {
        $this->consultant = $consultant;

        return $this;
    }

    public function getRecruiter(): ?Recruiter
    {
        return $this->recruiter;
    }

    public function setRecruiter(?Recruiter $recruiter): self
    {
        $this->recruiter = $recruiter;

        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getSchedule(): ?int
    {
        return $this->schedule;
    }

    public function setSchedule(int $schedule): self
    {
        $this->schedule = $schedule;

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
            $candidacy->setJobOffer($this);
        }

        return $this;
    }

    public function removeCandidacy(Candidacy $candidacy): self
    {
        if ($this->candidacies->removeElement($candidacy)) {
            // set the owning side to null (unless already changed)
            if ($candidacy->getJobOffer() === $this) {
                $candidacy->setJobOffer(null);
            }
        }

        return $this;
    }
}
