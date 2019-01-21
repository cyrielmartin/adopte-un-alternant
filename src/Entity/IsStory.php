<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IsStoryRepository")
 */
class IsStory
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
    private $witness_name;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Article", cascade={"persist", "remove"})
     */
    private $article;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWitnessName(): ?string
    {
        return $this->witness_name;
    }

    public function setWitnessName(string $witness_name): self
    {
        $this->witness_name = $witness_name;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }
}
