<?php

namespace App\Entity;

class Presentation
{
    /**
     * @var int
     */ 
    private $visibilityChoice;

    /**
     * @var string
     */ 
    private $phoneNumber;

    /**
     * Get the value of visibilityChoice
     */ 
    public function getVisibilityChoice()
    {
        return $this->visibilityChoice;
    }

    /**
     * Set the value of visibilityChoice
     *
     * @return  self
     */ 
    public function setVisibilityChoice($visibilityChoice)
    {
        $this->visibilityChoice = $visibilityChoice;

        return $this;
    }

    /**
     * Get the value of phoneNumber
     */ 
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set the value of phoneNumber
     *
     * @return  self
     */ 
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
}
