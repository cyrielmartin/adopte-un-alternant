<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisitCardRepository")
 */
class VisitCard
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $about;

    /**
     * @ORM\Column(type="boolean")
     */
    private $adopted;

    /**
     * @ORM\Column(type="smallint")
     */
    private $visibilityChoice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(string $about): self
    {
        $this->about = $about;

        return $this;
    }

    public function getAdopted(): ?bool
    {
        return $this->adopted;
    }

    public function setAdopted(bool $adopted): self
    {
        $this->adopted = $adopted;

        return $this;
    }

    public function getVisibilityChoice(): ?int
    {
        return $this->visibilityChoice;
    }

    public function setVisibilityChoice(int $visibilityChoice): self
    {
        $this->visibilityChoice = $visibilityChoice;

        return $this;
    }
}
