<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="text", nullable=true)
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Formation", mappedBy="visitCard")
     */
    private $formations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Experience", mappedBy="visitCard")
     */
    private $experiences;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Website", mappedBy="visitCard")
     */
    private $websites;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Additional", mappedBy="visitCard")
     */
    private $additionals;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\IsCandidate", cascade={"persist", "remove"})
     */
    private $isCandidate;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Skill", inversedBy="visitCards")
     * @Assert\Count(
     *      max = 5,
     *      maxMessage = "Vous ne pouvez pas choisir plus de {{ limit }} compétences"
     * )
     */
    private $skills;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Mobility", inversedBy="visitCards")
     */
    private $mobilities;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
        $this->experiences = new ArrayCollection();
        $this->websites = new ArrayCollection();
        $this->additionals = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->mobilities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout($about): self
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

    /**
     * @return Collection|Formation[]
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->setVisitCard($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->contains($formation)) {
            $this->formations->removeElement($formation);
            // set the owning side to null (unless already changed)
            if ($formation->getVisitCard() === $this) {
                $formation->setVisitCard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Experience[]
     */
    public function getExperiences(): Collection
    {
        return $this->experiences;
    }

    public function addExperience(Experience $experience): self
    {
        if (!$this->experiences->contains($experience)) {
            $this->experiences[] = $experience;
            $experience->setVisitCard($this);
        }

        return $this;
    }

    public function removeExperience(Experience $experience): self
    {
        if ($this->experiences->contains($experience)) {
            $this->experiences->removeElement($experience);
            // set the owning side to null (unless already changed)
            if ($experience->getVisitCard() === $this) {
                $experience->setVisitCard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Website[]
     */
    public function getWebsites(): Collection
    {
        return $this->websites;
    }

    public function addWebsite(Website $website): self
    {
        if (!$this->websites->contains($website)) {
            $this->websites[] = $website;
            $website->setVisitCard($this);
        }

        return $this;
    }

    public function removeWebsite(Website $website): self
    {
        if ($this->websites->contains($website)) {
            $this->websites->removeElement($website);
            // set the owning side to null (unless already changed)
            if ($website->getVisitCard() === $this) {
                $website->setVisitCard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Additional[]
     */
    public function getAdditionals(): Collection
    {
        return $this->additionals;
    }
    

    

    public function addAdditional(Additional $additional): self
    {
        if (!$this->additionals->contains($additional)) {
            $this->additionals[] = $additional;
            $additional->setVisitCard($this);
        }

        return $this;
    }

    public function removeAdditional(Additional $additional): self
    {
        if ($this->additionals->contains($additional)) {
            $this->additionals->removeElement($additional);
            // set the owning side to null (unless already changed)
            if ($additional->getVisitCard() === $this) {
                $additional->setVisitCard(null);
            }
        }

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

    public function getSkill(): Collection
    {
        return $this->skills;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->contains($skill)) {
            $this->skills->removeElement($skill);
        }

        return $this;
    }

    /**
     * @return Collection|Mobility[]
     */
    public function getMobilities(): Collection
    {
        return $this->mobilities;
    }

    public function addMobility(Mobility $mobility): self
    {
        if (!$this->mobilities->contains($mobility)) {
            $this->mobilities[] = $mobility;
        }

        return $this;
    }

    public function removeMobility(Mobility $mobility): self
    {
        if ($this->mobilities->contains($mobility)) {
            $this->mobilities->removeElement($mobility);
        }

        return $this;
    }
}
