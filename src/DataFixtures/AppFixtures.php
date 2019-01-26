<?php

namespace App\DataFixtures;

use App\Entity\Department;
use App\DataFixtures\Department\DepartmentProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // j'instance ma classe qui contient le tableau de département
        $dpt = new DepartmentProvider();
        // je récupère la liste complète des départements
        $departmentList = $dpt->getDepartmentList();

        // Pour chaque département de la liste je créer un nouveau champ dans ma table department
        foreach ($departmentList as $code => $name)
        {
            $newDepartment = new Department();
            $newDepartment->setName($name);
            $newDepartment->setCode($code);

            $manager->persist($newDepartment);
        }

        // J'insère tout mes ajouts en bdd
        $manager->flush();
    }
}
