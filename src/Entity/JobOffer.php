<?php

namespace App\Entity;

use App\Repository\JobOfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JobOfferRepository::class)
 */
class JobOffer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $jobTitle;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $workplace;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isValid;

    /**
     * @ORM\Column(type="integer")
     */
    private $salary;

    /**
     * @ORM\Column(type="integer")
     */
    private $schedule;

    /**
     * @ORM\OneToMany(targetEntity=Candidature::class, mappedBy="JobOffer", orphanRemoval=true)
     */
    private $candidatures;

    /**
     * @ORM\ManyToMany(targetEntity=Candidate::class, mappedBy="JobOffer")
     */
    private $candidates;

    /**
     * @ORM\ManyToOne(targetEntity=Consultant::class, inversedBy="consultant")
     */
    private $consultant;

    /**
     * @ORM\ManyToOne(targetEntity=JobOffer::class, inversedBy="jobOffers")
     */
    private $Consultant;

    /**
     * @ORM\OneToMany(targetEntity=JobOffer::class, mappedBy="Consultant")
     */
    private $jobOffers;

    /**
     * @ORM\ManyToOne(targetEntity=Recruteur::class, inversedBy="jobOffers")
     */
    private $Recruteur;

    /**
     * @ORM\ManyToOne(targetEntity=Recruteur::class, inversedBy="recruteur")
     */
    private $recruteur;

    public function __construct()
    {
        $this->candidatures = new ArrayCollection();
        $this->candidates = new ArrayCollection();
        $this->jobOffers = new ArrayCollection();
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
     * @return Collection<int, Candidature>
     */
    public function getCandidatures(): Collection
    {
        return $this->candidatures;
    }

    public function addCandidature(Candidature $candidature): self
    {
        if (!$this->candidatures->contains($candidature)) {
            $this->candidatures[] = $candidature;
            $candidature->setJobOffer($this);
        }

        return $this;
    }

    public function removeCandidature(Candidature $candidature): self
    {
        if ($this->candidatures->removeElement($candidature)) {
            // set the owning side to null (unless already changed)
            if ($candidature->getJobOffer() === $this) {
                $candidature->setJobOffer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Candidate>
     */
    public function getCandidates(): Collection
    {
        return $this->candidates;
    }

    public function addCandidate(Candidate $candidate): self
    {
        if (!$this->candidates->contains($candidate)) {
            $this->candidates[] = $candidate;
            $candidate->addJobOffer($this);
        }

        return $this;
    }

    public function removeCandidate(Candidate $candidate): self
    {
        if ($this->candidates->removeElement($candidate)) {
            $candidate->removeJobOffer($this);
        }

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

    /**
     * @return Collection<int, self>
     */
    public function getJobOffers(): Collection
    {
        return $this->jobOffers;
    }

    public function addJobOffer(self $jobOffer): self
    {
        if (!$this->jobOffers->contains($jobOffer)) {
            $this->jobOffers[] = $jobOffer;
            $jobOffer->setConsultant($this);
        }

        return $this;
    }

    public function removeJobOffer(self $jobOffer): self
    {
        if ($this->jobOffers->removeElement($jobOffer)) {
            // set the owning side to null (unless already changed)
            if ($jobOffer->getConsultant() === $this) {
                $jobOffer->setConsultant(null);
            }
        }

        return $this;
    }

    public function getRecruteur(): ?Recruteur
    {
        return $this->Recruteur;
    }

    public function setRecruteur(?Recruteur $Recruteur): self
    {
        $this->Recruteur = $Recruteur;

        return $this;
    }
}
