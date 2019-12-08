<?php


namespace App\DataFixtures;


use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    const ACTORS = [
        'Andrew Lincoln',
        'Norman Reedus',
        'Danai Gurira',
        'Lauren Cohan',
    ];
    public function load(ObjectManager $manager)
    {

        for ($i = 1; $i <= 50; $i++) {
            $actor = new Actor();
            $faker  =  Faker\Factory::create('us_US');
            $actor->setName($faker->name);
            $manager->persist($actor);
            $actor->addProgram($this->getReference('program_' . rand(0 , 5)));
        }

        foreach (self::ACTORS as $key => $actorName) {
            $actor = new Actor();
            $actor->setName($actorName);
            $actor->AddProgram($this->getReference('program_0'));
            $manager->persist($actor);
            $this->addReference('actor_' . $key, $actor);
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }

}