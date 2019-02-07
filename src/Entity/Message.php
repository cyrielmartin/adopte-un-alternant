<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
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
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $sendAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\IsRecruiter", inversedBy="messages")
     */
    private $isRecruiter;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\IsCandidate", inversedBy="messages")
     */
    private $isCandidate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sendBy;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSendAt()
    {
        return $this->sendAt;
    }

    public function setSendAt(\DateTimeInterface $sendAt): self
    {
        $this->sendAt = $sendAt;

        return $this;
    }

    public function getIsRecruiter(): ?IsRecruiter
    {
        return $this->isRecruiter;
    }

    public function setIsRecruiter(?IsRecruiter $isRecruiter): self
    {
        $this->isRecruiter = $isRecruiter;

        return $this;
    }

    public function getIsCandidate(): ?IsCandidate
    {
        return $this->isCandidate;
    }

    public function setIsCandidate(?IsCandidate $isCandidate): self
    {
        $this->isCandidate = $isCandidate;

        return $this;
    }

    public function getSendBy(): ?bool
    {
        return $this->sendBy;
    }

    public function setSendBy(bool $sendBy): self
    {
        $this->sendBy = $sendBy;

        return $this;
    }
}
