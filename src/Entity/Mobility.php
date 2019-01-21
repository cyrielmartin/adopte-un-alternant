<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MobilityRepository")
 */
class Mobility
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
    private $townName;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $departmentCode;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTownName(): ?string
    {
        return $this->townName;
    }

    public function setTownName(string $townName): self
    {
        $this->townName = $townName;

        return $this;
    }

    public function getDepartmentCode(): ?string
    {
        return $this->departmentCode;
    }

    public function setDepartmentCode(string $departmentCode): self
    {
        $this->departmentCode = $departmentCode;

        return $this;
    }
}
