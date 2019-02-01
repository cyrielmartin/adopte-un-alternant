<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WebsiteRepository")
 */
class Website
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
    private $name;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $link;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VisitCard", inversedBy="websites")
     */
    private $visitCard;

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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

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

    
}
