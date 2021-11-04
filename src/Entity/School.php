<?php

namespace App\Entity;

use App\Repository\SchoolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SchoolRepository::class)
 */
class School
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
     * @ORM\OneToMany(targetEntity=Course::class, mappedBy="school")
     */
    private $courses;

    /**
     * @ORM\ManyToMany(targetEntity=Course::class, mappedBy="schools")
     */
    private $coursesm2m;


    public function __construct()
    {
        $this->courses = new ArrayCollection();
        $this->coursesm2m = new ArrayCollection();
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

    /**
     * @return Collection|Course[]
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
            $course->setSchool($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getSchool() === $this) {
                $course->setSchool(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Course[]
     */
    public function getCoursesm2m(): Collection
    {
        return $this->coursesm2m;
    }

    public function addCoursesm2m(Course $coursesm2m): self
    {
        if (!$this->coursesm2m->contains($coursesm2m)) {
            $this->coursesm2m[] = $coursesm2m;
            $coursesm2m->addSchool($this);
        }

        return $this;
    }

    public function removeCoursesm2m(Course $coursesm2m): self
    {
        if ($this->coursesm2m->removeElement($coursesm2m)) {
            $coursesm2m->removeSchool($this);
        }

        return $this;
    }

}
