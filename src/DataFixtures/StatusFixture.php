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
            ['name' => 'Звонок', 'status' => 'CALL', 'color' => '#FFFFFF', ],
            ['name' => 'Встреча', 'status' => 'MEETING', 'color' => '#D9E8FF', ],
            ['name' => 'Приехал (в салоне)', 'status' => 'ARRIVED', 'color' => '#FFE9CB', ],
            ['name' => 'Архив', 'status' => 'ARCHIVED', 'color' => '#E0E0E0', ],
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
