<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class SearchCandidate
{
    /**
     * @var ArrayCollection
     */ 
    private $skills;
    
    /**
     * @var ArrayCollection
     */ 
    private $departments;

    /**
     * @var ArrayCollection
     */ 
    private $awards;
    
    // comme cette option est dans le SearchCandidate, elle doit être dans notre entité (qui n'est pas en base), il s'agit d'un tableau donc on déclare en Array donc propriété au pluriel
    //Dans le contructeur on dit qu'il y a un New Array Collection

    public function __construct(){
        $this->skills = New ArrayCollection();
        $this->departments = New ArrayCollection();
        $this->awards = New ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */ 
    public function getSkills(): ArrayCollection
    {
        return $this->skills;
    }

    public function setSkills($skill): void
    {
        $this->skills[] = $skill;
    }

    /**
     * @return ArrayCollection
     */ 
    public function getDepartments(): ArrayCollection
    {
        return $this->departments;
    }

    public function setDepartment($department): void
    {
        $this->departments[] = $department;
    }

    /**
     * @return ArrayCollection
     */ 
    public function getAwards(): ArrayCollection
    {
        return $this->awards;
    }

    public function setAward($award): void
    {
        $this->awards[] = $award;
    }
}