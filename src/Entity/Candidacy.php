<?php

namespace App\Entity;

use App\Repository\CandidacyRepository;
use Doctrine\ORM\Mapping as ORM;

# [ORM\Entity(repositoryClass: CandidacyRepository::class)]
class Candidacy
{
    # [ORM\Id]
    # [ORM\GeneratedValue]
    # [ORM\Column(type: 'integer')]
    private int $id;

    # [ORM\Column(type: 'boolean', nullable: true)]
    private bool $isValid = false;

    # [ORM\ManyToOne(targetEntity: Candidate::class, inversedBy: 'candidacies')]
    private ?Candidate $candidate;

    # [ORM\ManyToOne(targetEntity: JobOffer::class, inversedBy: 'candidacies')]
    # [ORM\JoinColumn(onDelete:'cascade')]
    private ?JobOffer $jobOffer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(?bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function getCandidate(): ?Candidate
    {
        return $this->candidate;
    }

    public function setCandidate(?Candidate $candidate): self
    {
        $this->candidate = $candidate;

        return $this;
    }

    public function getJobOffer(): ?JobOffer
    {
        return $this->jobOffer;
    }

    public function setJobOffer(?JobOffer $jobOffer): self
    {
        $this->jobOffer = $jobOffer;

        return $this;
    }
}
