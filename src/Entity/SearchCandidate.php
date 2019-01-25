<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class SearchCandidate{

    /**
     * @var ArrayCollection
     */ 
    private $skills;
    
    /**
     * @var ArrayCollection
     */ 
    private $mobilities;

    /**
     * @var ArrayCollection
     */ 
    private $awards;
    
    // comme cette option est dans le SearchCandidate, elle doit être dans notre entité (qui n'est pas en base), il s'agit d'un tableau donc on déclare en Array donc propriété au pluriel
    //Dans le contructeur on dit qu'il y a un New Array Collection

    public function __construct(){
        $this->skills = New ArrayCollection();
        $this->mobilities = New ArrayCollection();
        $this->awards = New ArrayCollection();
    }


    /**
     * @return ArrayCollection
     */ 
    public function getSkills(): ArrayCollection
    {
        return $this->skills;
    }

    /**
     * @param ArrayCollection $skills
     */ 
    public function setSkills(ArrayCollection $skills): void
    {
        $this->skills = $skills;

    }

    /**
     * @return ArrayCollection
     */ 
    public function getMobilities(): ArrayCollection
    {
        return $this->mobilities;
    }

    /**
     * @param ArrayCollection $mobilities
     */ 
    public function setMobilities(ArrayCollection $mobilities): void
    {
        $this->mobilities = $mobilities;
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