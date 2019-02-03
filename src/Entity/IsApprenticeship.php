<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IsApprenticeshipRepository")
 */
class IsApprenticeship
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $academicPace;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Formation", cascade={"persist", "remove"})
     * @Assert\Valid
     */
    private $formation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAcademicPace(): ?string
    {
        return $this->academicPace;
    }

    public function setAcademicPace(string $academicPace): self
    {
        $this->academicPace = $academicPace;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    public function __toString()
    {
        return $this->academicPace;
    }
}
