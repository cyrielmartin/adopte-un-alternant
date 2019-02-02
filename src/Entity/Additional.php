<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdditionalRepository")
 */
class Additional
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
    private $typeInfo;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VisitCard", inversedBy="additionals")
     */
    private $visitCard;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeInfo(): ?string
    {
        return $this->typeInfo;
    }

    public function setTypeInfo(string $typeInfo): self
    {
        $this->typeInfo = $typeInfo;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function __toString()
    {
        return $this->content;
    }
}
