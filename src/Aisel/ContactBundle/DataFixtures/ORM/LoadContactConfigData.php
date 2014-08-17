<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ContactBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\ConfigBundle\Entity\Config;

/**
 * Contact fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadContactConfigData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Set default settings for Contacts
     */
    public function load(ObjectManager $manager)
    {
        $config = new Config();
        $config->setEntity('config_contact');
        $config->setValue('{"Name":"Aisel Co.","Email":"service@email.com","AddressLine1":"1234 South Manhattan Place, LA","AddressLine2":null,"information":"<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.<\/p>"}');
        $manager->persist($config);
        $manager->flush();

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 900;
    }
}
