<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourseRepository::class)
 */
class Course
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sphere;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity=School::class, inversedBy="courses")
     */
    private $school;

    /**
     * @ORM\OneToMany(targetEntity=Checklist::class, mappedBy="anchor")
     */
    private $anchor_courses;

    /**
     * @ORM\OneToMany(targetEntity=Checklist::class, mappedBy="sphere1")
     */
    private $sphere1_courses;

    /**
     * @ORM\OneToMany(targetEntity=Checklist::class, mappedBy="sphere2")
     */
    private $sphere2_courses;

    /**
     * @ORM\OneToMany(targetEntity=Checklist::class, mappedBy="sphere3")
     */
    private $sphere3_courses;

    /**
     * @ORM\OneToMany(targetEntity=Checklist::class, mappedBy="seminar")
     */
    private $seminars;

    /**
     * @ORM\OneToMany(targetEntity=Checklist::class, mappedBy="capstone")
     */
    private $capstones;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;


    public function __construct()
    {
        $this->anchor_courses = new ArrayCollection();
        $this->sphere1_courses = new ArrayCollection();
        $this->sphere2_courses = new ArrayCollection();
        $this->sphere3_courses = new ArrayCollection();
        $this->seminars = new ArrayCollection();
        $this->capstones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSphere(): ?string
    {
        return $this->sphere;
    }

    public function setSphere(string $sphere): self
    {
        $this->sphere = $sphere;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getSchool(): ?School
    {
        return $this->school;
    }

    public function setSchool(?School $school): self
    {
        $this->school = $school;

        return $this;
    }

    /**
     * @return Collection|Checklist[]
     */
    public function getAnchorCourses(): Collection
    {
        return $this->anchor_courses;
    }

    public function addAnchorCourse(Checklist $anchorCourse): self
    {
        if (!$this->anchor_courses->contains($anchorCourse)) {
            $this->anchor_courses[] = $anchorCourse;
            $anchorCourse->setAnchor($this);
        }

        return $this;
    }

    public function removeAnchorCourse(Checklist $anchorCourse): self
    {
        if ($this->anchor_courses->removeElement($anchorCourse)) {
            // set the owning side to null (unless already changed)
            if ($anchorCourse->getAnchor() === $this) {
                $anchorCourse->setAnchor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Checklist[]
     */
    public function getSphere1Courses(): Collection
    {
        return $this->sphere1_courses;
    }

    public function addSphere1Course(Checklist $sphere1Course): self
    {
        if (!$this->sphere1_courses->contains($sphere1Course)) {
            $this->sphere1_courses[] = $sphere1Course;
            $sphere1Course->setSphere1($this);
        }

        return $this;
    }

    public function removeSphere1Course(Checklist $sphere1Course): self
    {
        if ($this->sphere1_courses->removeElement($sphere1Course)) {
            // set the owning side to null (unless already changed)
            if ($sphere1Course->getSphere1() === $this) {
                $sphere1Course->setSphere1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Checklist[]
     */
    public function getSphere2Courses(): Collection
    {
        return $this->sphere2_courses;
    }

    public function addSphere2Course(Checklist $sphere2Course): self
    {
        if (!$this->sphere2_courses->contains($sphere2Course)) {
            $this->sphere2_courses[] = $sphere2Course;
            $sphere2Course->setSphere2($this);
        }

        return $this;
    }

    public function removeSphere2Course(Checklist $sphere2Course): self
    {
        if ($this->sphere2_courses->removeElement($sphere2Course)) {
            // set the owning side to null (unless already changed)
            if ($sphere2Course->getSphere2() === $this) {
                $sphere2Course->setSphere2(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Checklist[]
     */
    public function getSphere3Courses(): Collection
    {
        return $this->sphere3_courses;
    }

    public function addSphere3Course(Checklist $sphere3Course): self
    {
        if (!$this->sphere3_courses->contains($sphere3Course)) {
            $this->sphere3_courses[] = $sphere3Course;
            $sphere3Course->setSphere3($this);
        }

        return $this;
    }

    public function removeSphere3Course(Checklist $sphere3Course): self
    {
        if ($this->sphere3_courses->removeElement($sphere3Course)) {
            // set the owning side to null (unless already changed)
            if ($sphere3Course->getSphere3() === $this) {
                $sphere3Course->setSphere3(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Checklist[]
     */
    public function getSeminars(): Collection
    {
        return $this->seminars;
    }

    public function addSeminar(Checklist $seminar): self
    {
        if (!$this->seminars->contains($seminar)) {
            $this->seminars[] = $seminar;
            $seminar->setSeminar($this);
        }

        return $this;
    }

    public function removeSeminar(Checklist $seminar): self
    {
        if ($this->seminars->removeElement($seminar)) {
            // set the owning side to null (unless already changed)
            if ($seminar->getSeminar() === $this) {
                $seminar->setSeminar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Checklist[]
     */
    public function getCapstones(): Collection
    {
        return $this->capstones;
    }

    public function addCapstone(Checklist $capstone): self
    {
        if (!$this->capstones->contains($capstone)) {
            $this->capstones[] = $capstone;
            $capstone->setCapstone($this);
        }

        return $this;
    }

    public function removeCapstone(Checklist $capstone): self
    {
        if ($this->capstones->removeElement($capstone)) {
            // set the owning side to null (unless already changed)
            if ($capstone->getCapstone() === $this) {
                $capstone->setCapstone(null);
            }
        }

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

}
