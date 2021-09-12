<?php

namespace App\DataFixtures;

use App\Entity\Application\Status;
use App\Entity\Dealer;
use App\Model\Enum\ApplicationStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class StatusFixture extends Fixture
{
    public function __construct(
        private SluggerInterface $slugger,
    ) {}

    public function load(ObjectManager $manager)
    {
        $statuses = [
            ['name' => 'Звонок', 'status' => 'CALL', 'color' => 'white', ],
            ['name' => 'Встреча', 'status' => 'MEETING', 'color' => 'blue', ],
            ['name' => 'Приехал (в салоне)', 'status' => 'ARRIVED', 'color' => 'yellow', ],
            ['name' => 'Архив', 'status' => 'ARCHIVED', 'color' => 'grey', ],
        ];

        $i = 0;
        foreach ($statuses as $i => $statusItem) {
            $i++;
            $status = new Status(
                $statusItem['name'],
                ApplicationStatus::get($statusItem['status']),
                $statusItem['color']
            );
            // $dealer->setName($dealerItem['name']);
            // $dealer->setSlug($dealerItem['slug']);
            // $dealer->setPriority($dealerItem['priority']);
            // $dealer->setDisabled($dealerItem['disabled']);
            
            $this->setReference("status-{$i}", $status);

            $manager->persist($status);
        }

        $manager->flush();
    }
}
