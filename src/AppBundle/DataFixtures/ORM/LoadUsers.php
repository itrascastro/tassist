<?php
/**
 * (c) Ismael Trascastro <i.trascastro@gmail.com>
 *
 * @link        http://www.ismaeltrascastro.com
 * @copyright   Copyright (c) Ismael Trascastro. (http://www.ismaeltrascastro.com)
 * @license     MIT License - http://en.wikipedia.org/wiki/MIT_License
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUsers implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin
            ->setUsername('itrascastro@email.com')
            ->setForename('Ismael')
            ->setSurname('Trascastro')
            ->setPlainPassword('1234')
            ->setRoles(['ROLE_ADMIN'])
            ->setMondayIn(new \DateTime('15:00'))
            ->setMondayOut(new \DateTime('21:00'))
            ->setTuesdayIn(new \DateTime('19:40'))
            ->setTuesdayOut(new \DateTime('19:30'))
            ->setWednesdayIn(new \DateTime('15:00'))
            ->setWednesdayOut(new \DateTime('21:00'))
            ->setThursdayIn(new \DateTime('15:00'))
            ->setThursdayOut(new \DateTime('21:00'))
            ->setFridayIn(new \DateTime('15:00'))
            ->setFridayOut(new \DateTime('21:00'))
        ;
        $manager->persist($admin);

        $manager->flush();
    }
}