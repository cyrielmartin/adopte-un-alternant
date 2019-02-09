<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IsRecruiterRepository")
 */
class IsRecruiter
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $companyName;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $companyLocation;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\IsCandidate", mappedBy="isRecruiters")
     */
    private $isCandidates;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="isRecruiter")
     */
    private $messages;

    public function __construct()
    {
        $this->isCandidates = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName($companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getCompanyLocation(): ?string
    {
        return $this->companyLocation;
    }

    public function setCompanyLocation(?string $companyLocation): self
    {
        $this->companyLocation = $companyLocation;

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

    /**
     * @return Collection|IsCandidate[]
     */
    public function getIsCandidates(): Collection
    {
        return $this->isCandidates;
    }

    public function addIsCandidate(IsCandidate $isCandidate): self
    {
        if (!$this->isCandidates->contains($isCandidate)) {
            $this->isCandidates[] = $isCandidate;
            $isCandidate->addIsRecruiter($this);
        }

        return $this;
    }

    public function removeIsCandidate(IsCandidate $isCandidate): self
    {
        if ($this->isCandidates->contains($isCandidate)) {
            $this->isCandidates->removeElement($isCandidate);
            $isCandidate->removeIsRecruiter($this);
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setIsRecruiter($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getIsRecruiter() === $this) {
                $message->setIsRecruiter(null);
            }
        }

        return $this;
    }
}
