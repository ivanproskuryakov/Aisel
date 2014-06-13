<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Frontend users fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadFrontendUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Aisel Frontend user manager
     * @return \Aisel\UserBundle\Manager\UserManager
     */
    protected function getUserManager()
    {
        return $this->container->get('frontend.user.manager');
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userData = array(
            'username'=>'frontenduser',
            'password'=>'frontenduser',
            'email'=>'frontenduser@aisel.co',
            'phone'=>'+7(123)123-1234',
            'website'=>'http://aisel.co/',
            'facebook'=>'https://www.facebook.com/pages/Aisel/1439524699618478',
            'twitter'=>'https://twitter.com/aisel',
            'linkedin'=>'www.linkedin.com/pub/ivan-proskuryakov/31/200/316',
            'googleplus'=>'https://plus.google.com/+aisel',
            'github'=>'https://github.com/ivanproskuryakov/Aisel',
            'behance'=>'https://www.behance.net/aisel',
            'about'=>'orem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dol',
        );
        $user = $this->getUserManager()->registerFixturesUser($userData);
        $this->addReference('frontenduser', $user);

        $userData = array(
            'username'=>'volgodark',
            'password'=>'volgodark',
            'email'=>'volgodark@gmail.com',
            'phone'=>'+7(909)389-2222',
            'website'=>'http://aisel.co/',
            'facebook'=>'https://www.facebook.com/pages/Aisel/1439524699618478',
            'twitter'=>'https://twitter.com/aisel',
            'linkedin'=>'www.linkedin.com/pub/ivan-proskuryakov/31/200/316',
            'googleplus'=>'https://plus.google.com/+aisel',
            'github'=>'https://github.com/ivanproskuryakov/Aisel',
            'behance'=>'https://www.behance.net/aisel',
            'about'=>'nothing here ...',
        );
        $user = $this->getUserManager()->registerFixturesUser($userData);

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
