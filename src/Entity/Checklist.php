<?php

namespace App\Entity;

use App\Repository\ChecklistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChecklistRepository::class)
 */
class Checklist
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="checklists")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $presentation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $athena;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $pre_assess;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $post_assess;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $orientation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $appliedtograd;

    /**
     * @ORM\ManyToOne(targetEntity=Course::class, inversedBy="anchor_courses")
     */
    private $anchor;

    /**
     * @ORM\ManyToOne(targetEntity=Course::class, inversedBy="sphere1_courses")
     */
    private $sphere1;

    /**
     * @ORM\ManyToOne(targetEntity=Course::class, inversedBy="sphere2_courses")
     */
    private $sphere2;

    /**
     * @ORM\ManyToOne(targetEntity=Course::class, inversedBy="sphere3_courses")
     */
    private $sphere3;

    /**
     * @ORM\ManyToOne(targetEntity=Course::class, inversedBy="seminars")
     */
    private $seminar;

    /**
     * @ORM\ManyToOne(targetEntity=Course::class, inversedBy="capstones")
     */
    private $capstone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $school;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $program;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $exceptions;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $portfolio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $capstonedate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $capstoneterm;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $port_date;

    /**
     * @ORM\OneToMany(targetEntity=Substitution::class, mappedBy="checklist")
     */
    private $substitutions;

    public function __construct()
    {
        $this->substitutions = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getAthena(): ?\DateTimeInterface
    {
        return $this->athena;
    }

    public function setAthena(?\DateTimeInterface $athena): self
    {
        $this->athena = $athena;

        return $this;
    }

    public function getPreAssess(): ?\DateTimeInterface
    {
        return $this->pre_assess;
    }

    public function setPreAssess(?\DateTimeInterface $pre_assess): self
    {
        $this->pre_assess = $pre_assess;

        return $this;
    }

    public function getPostAssess(): ?\DateTimeInterface
    {
        return $this->post_assess;
    }

    public function setPostAssess(?\DateTimeInterface $post_assess): self
    {
        $this->post_assess = $post_assess;

        return $this;
    }

    public function getOrientation(): ?\DateTimeInterface
    {
        return $this->orientation;
    }

    public function setOrientation(?\DateTimeInterface $orientation): self
    {
        $this->orientation = $orientation;

        return $this;
    }

    public function getAppliedtograd(): ?string
    {
        return $this->appliedtograd;
    }

    public function setAppliedtograd(?string $appliedtograd): self
    {
        $this->appliedtograd = $appliedtograd;

        return $this;
    }

    public function getAnchor(): ?Course
    {
        return $this->anchor;
    }

    public function setAnchor(?Course $anchor): self
    {
        $this->anchor = $anchor;

        return $this;
    }

    public function getSphere1(): ?Course
    {
        return $this->sphere1;
    }

    public function setSphere1(?Course $sphere1): self
    {
        $this->sphere1 = $sphere1;

        return $this;
    }

    public function getSphere2(): ?Course
    {
        return $this->sphere2;
    }

    public function setSphere2(?Course $sphere2): self
    {
        $this->sphere2 = $sphere2;

        return $this;
    }

    public function getSphere3(): ?Course
    {
        return $this->sphere3;
    }

    public function setSphere3(?Course $sphere3): self
    {
        $this->sphere3 = $sphere3;

        return $this;
    }

    public function getSeminar(): ?Course
    {
        return $this->seminar;
    }

    public function setSeminar(?Course $seminar): self
    {
        $this->seminar = $seminar;

        return $this;
    }

    public function getCapstone(): ?Course
    {
        return $this->capstone;
    }

    public function setCapstone(?Course $capstone): self
    {
        $this->capstone = $capstone;

        return $this;
    }

    public function getSchool(): ?string
    {
        return $this->school;
    }

    public function setSchool(?string $school): self
    {
        $this->school = $school;

        return $this;
    }

    public function getProgram(): ?string
    {
        return $this->program;
    }

    public function setProgram(?string $program): self
    {
        $this->program = $program;

        return $this;
    }

    public function getExceptions(): ?string
    {
        return $this->exceptions;
    }

    public function setExceptions(?string $exceptions): self
    {
        $this->exceptions = $exceptions;

        return $this;
    }

    public function getPortfolio(): ?string
    {
        return $this->portfolio;
    }

    public function setPortfolio(?string $portfolio): self
    {
        $this->portfolio = $portfolio;

        return $this;
    }

    public function getCapstonedate(): ?string
    {
        return $this->capstonedate;
    }

    public function setCapstonedate(?string $capstonedate): self
    {
        $this->capstonedate = $capstonedate;

        return $this;
    }

    public function getCapstoneterm(): ?string
    {
        return $this->capstoneterm;
    }

    public function setCapstoneterm(?string $capstoneterm): self
    {
        $this->capstoneterm = $capstoneterm;

        return $this;
    }

    public function getPortDate(): ?\DateTimeInterface
    {
        return $this->port_date;
    }

    public function setPortDate(?\DateTimeInterface $port_date): self
    {
        $this->port_date = $port_date;

        return $this;
    }

    /**
     * @return Collection|Substitution[]
     */
    public function getSubstitutions(): Collection
    {
        return $this->substitutions;
    }

    public function addSubstitution(Substitution $substitution): self
    {
        if (!$this->substitutions->contains($substitution)) {
            $this->substitutions[] = $substitution;
            $substitution->setChecklist($this);
        }

        return $this;
    }

    public function removeSubstitution(Substitution $substitution): self
    {
        if ($this->substitutions->removeElement($substitution)) {
            // set the owning side to null (unless already changed)
            if ($substitution->getChecklist() === $this) {
                $substitution->setChecklist(null);
            }
        }

        return $this;
    }

}
