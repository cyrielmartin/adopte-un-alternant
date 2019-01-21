<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string", length=50)
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $emailCustom;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
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

    public function getEmailCustom(): ?string
    {
        return $this->emailCustom;
    }

    public function setEmailCustom(?string $emailCustom): self
    {
        $this->emailCustom = $emailCustom;

        return $this;
    }
}
