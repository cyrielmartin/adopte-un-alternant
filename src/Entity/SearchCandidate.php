<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class SearchCandidate{

    /**
     * @var ArrayCollection
     */ 
    private $candidateSkills;
    
    // comme cette option est dans le SearchCandidate, elle doit être dans notre entité (qui n'est pas en base), il s'agit d'un tableau donc on déclare en Array donc propriété au pluriel
    //Dans le contructeur on dit qu'il y a un New Array Collection

    public function __construct(){
        $this->candidateSkills =New ArrayCollection();
    }

    



    

    /**
     * @return ArrayCollection
     */ 
    public function getCandidateSkills(): ArrayCollection
    {
        return $this->candidateSkills;
    }

    /**
     * @param ArrayCollection $candidateSkills
     */ 
    public function setCandidateSkills(ArrayCollection $candidateSkills): void
    {
        $this->candidateSkills = $candidateSkills;

    }
}