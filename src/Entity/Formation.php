<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FormationRepository")
 */
class Formation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $awardName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startedAt;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $obtainedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\Expression("value > this.getStartedAt()",
     *      message = "Données invalides: Dates de début et fin de formation incohérentes")
     */
    private $endedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VisitCard", inversedBy="formations")
     */
    private $visitCard;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AwardLevel", inversedBy="formations")
     */
    private $awardLevel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\School", inversedBy="formations")
     */
    private $school;

    public function getAwardName(): ?string
    {
        return $this->awardName;
    }

    public function setAwardName(string $awardName): self
    {
        $this->awardName = $awardName;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeInterface
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeInterface $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
    
    public function getObtainedAt(): ?\DateTimeInterface
    {
        return $this->obtainedAt;
    }

    public function setObtainedAt(?\DateTimeInterface $obtainedAt): self
    {
        $this->obtainedAt = $obtainedAt;

        return $this;
    }

    public function getEndedAt(): ?\DateTimeInterface
    {
        return $this->endedAt;
    }

    public function setEndedAt(?\DateTimeInterface $endedAt): self
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    public function getVisitCard(): ?VisitCard
    {
        return $this->visitCard;
    }

    public function setVisitCard(?VisitCard $visitCard): self
    {
        $this->visitCard = $visitCard;

        return $this;
    }

    public function getAwardLevel(): ?AwardLevel
    {
        return $this->awardLevel;
    }

    public function setAwardLevel(?AwardLevel $awardLevel): self
    {
        $this->awardLevel = $awardLevel;

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
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    public function getFormation()
    {
        // pour faire plaisir au formulaire
        return $this;
    }

    public function __toString()
    {
        return $this->awardName;
    }
}
