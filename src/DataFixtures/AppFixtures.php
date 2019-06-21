<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{


    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // fix administrateur
        $user = new User();
        $user->setEmail("dhiua99@gmail.com")
            ->setRoles("ROLE_ADMIN")
            ->setPassword($this->encoder->encodePassword($user, '123698745'))
            ->setFirstName("Mohamed Dhia")
            ->setLastName("Hachem");
        $manager->persist($user);

        $manager->flush();
    }
}
