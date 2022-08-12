<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="cert_user")
 */

class User implements UserInterface, EquatableInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = ["ROLE_USER"];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\OneToMany(targetEntity=Checklist::class, mappedBy="user")
     */
    private $checklists;

    /**
     * @ORM\OneToMany(targetEntity=Application::class, mappedBy="user")
     */
    private $applications;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $progress='Application';

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $altemail;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gradterm;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gradyear;

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
    private $minors;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $portfolio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $certificates;

    public function __construct()
    {
        $this->checklists = new ArrayCollection();
        $this->applications = new ArrayCollection();
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    public function isEqualTo(UserInterface $user): ?bool
    {
        return true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection|Checklist[]
     */
    public function getChecklists(): Collection
    {
        return $this->checklists;
    }

    public function addChecklist(Checklist $checklist): self
    {
        if (!$this->checklists->contains($checklist)) {
            $this->checklists[] = $checklist;
            $checklist->setUser($this);
        }

        return $this;
    }

    public function removeChecklist(Checklist $checklist): self
    {
        if ($this->checklists->removeElement($checklist)) {
            // set the owning side to null (unless already changed)
            if ($checklist->getUser() === $this) {
                $checklist->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Application[]
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications[] = $application;
            $application->setUser($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getUser() === $this) {
                $application->setUser(null);
            }
        }

        return $this;
    }

    public function getProgress(): ?string
    {
        return $this->progress;
    }

    public function setProgress(?string $progress): self
    {
        $this->progress = $progress;

        return $this;
    }

    public function getAltemail(): ?string
    {
        return $this->altemail;
    }

    public function setAltemail(?string $altemail): self
    {
        $this->altemail = $altemail;

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

    public function getGradyear(): ?string
    {
        return $this->gradyear;
    }

    public function setGradyear(?string $gradyear): self
    {
        $this->gradyear = $gradyear;

        return $this;
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

    public function getMinors(): ?string
    {
        return $this->minors;
    }

    public function setMinors(?string $minors): self
    {
        $this->minors = $minors;

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

    public function getCertificates(): ?string
    {
        return $this->certificates;
    }

    public function setCertificates(?string $certificates): self
    {
        $this->certificates = $certificates;

        return $this;
    }
}
