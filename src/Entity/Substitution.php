<?php

namespace App\Entity;

use App\Repository\SubstitutionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubstitutionRepository::class)
 */
class Substitution
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $requirement;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Checklist::class, inversedBy="substitutions")
     */
    private $checklist;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequirement(): ?string
    {
        return $this->requirement;
    }

    public function setRequirement(?string $requirement): self
    {
        $this->requirement = $requirement;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getChecklist(): ?Checklist
    {
        return $this->checklist;
    }

    public function setChecklist(?Checklist $checklist): self
    {
        $this->checklist = $checklist;

        return $this;
    }
}
