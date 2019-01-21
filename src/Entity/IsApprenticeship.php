<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
}
