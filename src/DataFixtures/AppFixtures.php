<?php

namespace App\DataFixtures;

use App\Entity\Level;
use App\Entity\Status;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadLevels($manager);
        $this->loadStatus($manager);
        $this->loadTypes($manager);
    }

    private function loadLevels(ObjectManager $manager){
        $levels = [
            ["priority"=>1, "label"=>"Non urgent"],
            ["priority"=>2, "label"=>"Urgent"],
            ["priority"=>3, "label"=>"Bloquant"],
            ["priority"=>4, "label"=>"Critique"],
        ];

        foreach($levels as $data){
            $level = new Level($data["label"],$data["priority"]);
            $manager->persist($level);
        }
        $manager->flush();
    }

    private function loadStatus(ObjectManager $manager){
        $statuses = [
            ["normalized"=>"NEW", "label"=>"Nouveau"],
            ["normalized"=>"PROCESSING", "label"=>"En cours de traitement"],
            ["normalized"=>"RESOLVED", "label"=>"Résolu"],
            ["normalized"=>"REJECTED", "label"=>"Rejeté"],
        ];

        foreach($statuses as $data){
            $status = new Status($data["normalized"],$data["label"]);
            $manager->persist($status);
        }
        $manager->flush();
    }

    private function loadTypes(ObjectManager $manager){
        $types = [
            "Messagerie",
            "Téléphonie",
            "Applicatifs",
            "Bureautique",
            "Poste de travail",
            "Accès distant",
            "Autre"
        ];

        sort($types);

        foreach($types as $data){
            $type = new Type($data);
            $manager->persist($type);
        }

        $manager->flush();
    }
}
