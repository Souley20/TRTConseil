<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CandidatureRepository::class)
 */
class Candidature
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isValid;

    /**
     * @ORM\ManyToOne(targetEntity=Candidate::class, inversedBy="candidatures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Candidate;

    /**
     * @ORM\ManyToOne(targetEntity=JobOffer::class, inversedBy="candidatures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $JobOffer;

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
        return $this->Candidate;
    }

    public function setCandidate(?Candidate $Candidate): self
    {
        $this->Candidate = $Candidate;

        return $this;
    }

    public function getJobOffer(): ?JobOffer
    {
        return $this->JobOffer;
    }

    public function setJobOffer(?JobOffer $JobOffer): self
    {
        $this->JobOffer = $JobOffer;

        return $this;
    }
}
