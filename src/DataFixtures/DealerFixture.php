<?php

namespace App\DataFixtures;

use App\Entity\Dealer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class DealerFixture extends Fixture
{
    public function __construct(
        private SluggerInterface $slugger,
    ) {}

    public function load(ObjectManager $manager)
    {
        $dealers = [
            ['name' => 'Риа Авто', 'slug' => 'riaauto', 'priority' => 1, 'disabled' => false, ],
            ['name' => 'Масмоторс', 'slug' => 'masmotors', 'priority' => 2, 'disabled' => false, ],
        ];

        $i = 0;
        foreach ($dealers as $i => $dealerItem) {
            $i++;
            $dealer = new Dealer();
            $dealer->setName($dealerItem['name']);
            $dealer->setSlug($dealerItem['slug']);
            $dealer->setPriority($dealerItem['priority']);
            $dealer->setDisabled($dealerItem['disabled']);
            
            $this->setReference("dealer-{$i}", $dealer);

            $manager->persist($dealer);
        }

        $manager->flush();
    }
}
