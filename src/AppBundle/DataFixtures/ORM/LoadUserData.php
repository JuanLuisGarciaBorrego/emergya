<?php
/**
 * Created by PhpStorm.
 * User: juanluis
 * Date: 2/2/16
 * Time: 14:12
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setNick('User'.$i);
            $user->setMessage('Este es un texto de prueba para el anuncio.');
            $manager->persist($user);
        }
        $manager->flush();

    }
}