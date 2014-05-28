<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\ConfigBundle\Entity\Config;

/**
 * Fixtures for CMS configration settings
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadConfigData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $config = new Config();
        $config->setEntity('config_homepage');
        $config->setValue('{"content":"<div class=\"jumbotron\">\r\n        <h1>This is Homepage<\/h1>\r\n        <p class=\"lead\">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.<\/p>\r\n        <p><a class=\"btn btn-lg btn-success\" href=\"#\" role=\"button\">Read more<\/a><\/p>\r\n      <\/div>\r\n<div class=\"row marketing\">\r\n        <div class=\"col-lg-6\">\r\n          <h4>Subheading<\/h4>\r\n          <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.<\/p>\r\n\r\n          <h4>Subheading<\/h4>\r\n          <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.<\/p>\r\n\r\n          <h4>Subheading<\/h4>\r\n          <p>Maecenas sed diam eget risus varius blandit sit amet non magna.<\/p>\r\n        <\/div>\r\n\r\n        <div class=\"col-lg-6\">\r\n          <h4>Subheading<\/h4>\r\n          <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.<\/p>\r\n\r\n          <h4>Subheading<\/h4>\r\n          <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.<\/p>\r\n\r\n          <h4>Subheading<\/h4>\r\n          <p>Maecenas sed diam eget risus varius blandit sit amet non magna.<\/p>\r\n        <\/div>\r\n      <\/div>"}');
        $manager->persist($config);
        $manager->flush();

        $config = new Config();
        $config->setEntity('config_meta');
        $config->setValue('{"defaultMetaTitle":"Aisel - open source project","defaultMetaDescription":"Modern CMS based on shoulders of giants","defaultMetaKeywords":"Aisel, Symfony, AngularJS"}');
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
