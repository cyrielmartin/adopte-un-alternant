<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MobilityRepository")
 */
class Mobility
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
    private $townName;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\VisitCard", inversedBy="mobilities")
     */
    private $visitCards;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="mobilities")
     */
    private $department;

    public function __construct()
    {
        $this->visitCards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTownName(): ?string
    {
        return $this->townName;
    }

    public function setTownName(string $townName): self
    {
        $this->townName = $townName;

        return $this;
    }

    /**
     * @return Collection|VisitCard[]
     */
    public function getVisitCards(): Collection
    {
        return $this->visitCards;
    }

    public function addVisitCard(VisitCard $visitCard): self
    {
        if (!$this->visitCards->contains($visitCard)) {
            $this->visitCards[] = $visitCard;
        }

        return $this;
    }

    public function removeVisitCard(VisitCard $visitCard): self
    {
        if ($this->visitCards->contains($visitCard)) {
            $this->visitCards->removeElement($visitCard);
        }

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }
}
