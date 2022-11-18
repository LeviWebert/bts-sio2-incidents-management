<?php

namespace App\DataFixtures;

use App\Entity\Level;
use App\Entity\Status;
use App\Entity\Incident;
use App\Entity\Type;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    private Generator $faker;
    public function __construct()
    {
        $this->faker=Factory::create('fr-FR');
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadLevels($manager);
        $this->loadStatus($manager);
        $this->loadTypes($manager);
        $this->loadTickets($manager);
        $this->loadUser($manager);
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

    private function loadTickets(ObjectManager $manager){
        $types = $manager->getRepository(Type::class)->findAll();
        $statuses = $manager->getRepository(Status::class)->findAll();
        $levels = $manager->getRepository(Level::class)->findAll();

        for($i = 0; $i< 50;$i++){

            $typeskeys = array_rand($types,rand(2,4));
            $levelKey = array_rand($levels,1);
            $statusKey = array_rand($statuses,1);

            $ticket = new Incident();
            $ticket->setReporterEmail($this->faker->email);
            $ticket->setDescription($this->faker->paragraph(3,true));
            $ticket->setLevel($levels[$levelKey]);
            $ticket->setStatus($statuses[$statusKey]);

            switch ($ticket->getStatus()->getNormalized()){
                case "PROCESSING":
                    $ticket->setProcessedAt($ticket->getCreatedAt()->modify("+1 day"));
                    break;
                case "REJECTED":
                    $ticket->setProcessedAt($ticket->getCreatedAt()->modify("+1 day"));
                    $ticket->setRejectedAt($ticket->getCreatedAt()->modify("+2 day"));
                    break;
                case "RESOLVED":
                    $ticket->setProcessedAt($ticket->getCreatedAt()->modify("+1 day"));
                    $ticket->setResolveAt($ticket->getCreatedAt()->modify("+2 day"));
                    break;
                default:
                    break;
            }

            foreach($typeskeys as $typeKey){
                $ticket->addType($types[$typeKey]);
            }

            $manager->persist($ticket);

        }

        $manager->flush();
    }

    public function loadUser(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setEmail($this->faker->email)

            ->setRoles(['ROLE_USER'])
            ->setPassword('1234');
        $manager->persist($userAdmin);
        for ($i=0;$i<10;$i++)
        {
            $user = new User();
            $user->setEmail($this->faker->email)
                ->setRoles(['ROLE_USER'])
                ->setPassword('1234');
            $manager->persist($user);
        }
        $manager->flush();

    }

}
