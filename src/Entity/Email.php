<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;

class Email
{
    /**
     * @var string
     */ 
    private $subject;

     /**
     * @var string|null
     */ 
    
    private $text;

    /**
     * @var User
     */ 
    
    private $recruiter;
    
    /**
     * @var User
     */ 
    
    private $recruiterEmail;

    /**
     * @var User
     */ 
    
    private $candidateEmail;

    /**
     * @var User
     */ 
    
    private $companyName;
   


    /**
     * Get the value of subject
     */ 
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * Set the value of subject
     *
     * @return  Email
     */ 
    public function setSubject(?string $subject): Email
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get the value of subject
     */ 
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * Set the value of subject
     *
     * @return  Email
     */ 
    public function setText(?string $text): Email
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get the value of subject
     */ 
    public function getRecruiter(): ?string
    {
        return $this->recruiter;
    }

    /**
     * Set the value of subject
     *
     * @return  Email
     */ 
    public function setRecruiter(?string $recruiter): Email
    {
        $this->recruiter = $recruiter;

        return $this;
    }

     /**
     * Get the value of subject
     */ 
    public function getRecruiterEmail(): ?string
    {
        return $this->recruiterEmail;
    }

    /**
     * Set the value of subject
     *
     * @return  Email
     */ 
    public function setRecruiterEmail(?string $recruiterEmail): Email
    {
        $this->recruiterEmail = $recruiterEmail;

        return $this;
    }

     /**
     * Get the value of subject
     */ 
    public function getCandidateEmail(): ?string
    {
        return $this->candidateEmail;
    }

    /**
     * Set the value of subject
     *
     * @return  Email
     */ 
    public function setCandidateEmail(?string $candidateEmail): Email
    {
        $this->candidateEmail = $candidateEmail;

        return $this;
    }

     /**
     * Get the value of subject
     */ 
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * Set the value of subject
     *
     * @return  Email
     */ 
    public function setCompanyName(?string $companyName): Email
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function __toString(){
        return $this->recruiter;
    }

    
}