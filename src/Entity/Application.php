<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ApplicationRepository::class)
 */
class Application
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
    private $ugaid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $level = "Undergrad";

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $interest;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $experience;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $goals;


    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="applications")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status='Ready for Review';

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @ORM\ManyToOne(targetEntity=School::class)
     */
    private $school1;

    /**
     * @ORM\ManyToOne(targetEntity=School::class)
     */
    private $school2;

    /**
     * @ORM\ManyToOne(targetEntity=Major::class)
     */
    private $major1;

    /**
     * @ORM\ManyToOne(targetEntity=Major::class)
     */
    private $major2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $degree;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $institution;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $graddate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gradterm;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUgaid(): ?string
    {
        return $this->ugaid;
    }

    public function setUgaid(?string $ugaid): self
    {
        $this->ugaid = $ugaid;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getInterest(): ?string
    {
        return $this->interest;
    }

    public function setInterest(?string $interest): self
    {
        $this->interest = $interest;

        return $this;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(?string $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getGoals(): ?string
    {
        return $this->goals;
    }

    public function setGoals(?string $goals): self
    {
        $this->goals = $goals;

        return $this;
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function getSchool1(): ?School
    {
        return $this->school1;
    }

    public function setSchool1(?School $school1): self
    {
        $this->school1 = $school1;

        return $this;
    }

    public function getSchool2(): ?School
    {
        return $this->school2;
    }

    public function setSchool2(?School $school2): self
    {
        $this->school2 = $school2;

        return $this;
    }

    public function getMajor1(): ?Major
    {
        return $this->major1;
    }

    public function setMajor1(?Major $major1): self
    {
        $this->major1 = $major1;

        return $this;
    }

    public function getMajor2(): ?Major
    {
        return $this->major2;
    }

    public function setMajor2(?Major $major2): self
    {
        $this->major2 = $major2;

        return $this;
    }

    public function getDegree(): ?string
    {
        return $this->degree;
    }

    public function setDegree(?string $degree): self
    {
        $this->degree = $degree;

        return $this;
    }

    public function getInstitution(): ?string
    {
        return $this->institution;
    }

    public function setInstitution(?string $institution): self
    {
        $this->institution = $institution;

        return $this;
    }

    public function getGraddate(): ?string
    {
        return $this->graddate;
    }

    public function setGraddate(?string $graddate): self
    {
        $this->graddate = $graddate;

        return $this;
    }

    public function getGradterm(): ?string
    {
        return $this->gradterm;
    }

    public function setGradterm(?string $gradterm): self
    {
        $this->gradterm = $gradterm;

        return $this;
    }
}
