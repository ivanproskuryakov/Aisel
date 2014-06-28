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
        $config->setValue('{"content":"<div class=\"jumbotron\">\r\n<h1>This is Homepage<\/h1>\r\n\r\n<p>Our Macbook mockups are available in high quality 1024x768 resolution for maximum detail and enhanced visuals. It can be difficult to simply explain an app to a client, which is why a visual representation like the kind a mockup can offer is so useful. Whatever type of application you have created, it will be important that you represent it properly to the clients. You will find that our Macbook mockups come in a variety of angles with different backgrounds to choose from so you can find the perfect one for your presentation.<\/p>\r\n<\/div>\r\n\r\n<div class=\"row marketing\">\r\n<div class=\"col-lg-6\">\r\n<h4>Subheading<\/h4>\r\n\r\n<p>Every application designer needs to have high quality mockups for the device that they are designing it for, which is where we come in. We have the best Apple device mockups on the&nbsp;<\/p>\r\n\r\n<h4>Subheading<\/h4>\r\n\r\n<p>internet, including those which are for the Macbook Pro and Air, for designers who really want to impress their clients. All you have to do is simply choose a photo or screen shot of your app&nbsp;<\/p>\r\n\r\n<h4>Subheading<\/h4>\r\n\r\n<p>and in minutes you will receive the finished product to use in your presentation. We take pride in providing our customers with high quality products which have been used by countless designers&nbsp;<\/p>\r\n<\/div>\r\n\r\n<div class=\"col-lg-6\">\r\n<h4>Subheading<\/h4>\r\n\r\n<p>Anyone who has designed an application and needs to showcase it to clients will need to consider the immense benefits of using a Macbook mockup. These mockups are realistic high&nbsp;<\/p>\r\n\r\n<h4>Subheading<\/h4>\r\n\r\n<p>quality representations of Apple devices which can be very useful when it comes to showing clients what you have created. Whether it is an app for finding restaurants in a given area or&nbsp;<\/p>\r\n\r\n<h4>Subheading<\/h4>\r\n\r\n<p>One of the primary benefits of the Macbook mockups we offer is that they are able to save designers a lot of time, which can be a great thing, especially considering all of the work that&nbsp;<\/p>\r\n<\/div>\r\n<\/div>"}');
        $manager->persist($config);
        $manager->flush();

        $config = new Config();
        $config->setEntity('config_meta');
        $config->setValue('{"defaultMetaTitle":"Aisel - open source project","defaultMetaDescription":"Highload CMS based on Symfony2 and AngularJS","defaultMetaKeywords":"Aisel, Symfony, AngularJS"}');
        $manager->persist($config);
        $manager->flush();

        $config = new Config();
        $config->setEntity('config_disqus');
        $config->setValue('{"shortname":"demoaiselco","status":1}');
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
