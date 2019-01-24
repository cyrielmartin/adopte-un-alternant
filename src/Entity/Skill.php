<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SkillRepository")
 */
class Skill
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\VisitCard", inversedBy="skills")
     */
    private $visitCards;

    public function __construct()
    {
        $this->visitCards = new ArrayCollection();
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
    
}
