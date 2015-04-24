<?php

namespace Aisel\ResourceBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Client;
use Aisel\BackendUserBundle\Manager\UserManager;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;

/**
 * Class AbstractWebTestCase.
 */
abstract class AbstractWebTestCase extends KernelTestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var UserManager
     */
    protected $um;

    /**
     * @var array $locales
     */
    protected $locales;

    /**
     * @var KernelInterface
     */
    protected static $kernel = null;

    /**
     * @var string
     */
    protected static $httpHost = null;

    /**
     * @var integer
     */
    protected static $seed = 2000;

    public static function setUpBeforeClass($httpHost = 'api.aisel.dev')
    {
        static::$httpHost = $httpHost;
    }

    public function logInBackend($username = 'backenduser')
    {
        if ($this->um->isAuthenticated() === false) {

            $security = static::$kernel->getContainer()->get('security.context');
            $session = $this->client->getContainer()->get('session');
            $session->start();

            $user = $this->um->loadUserByUsername($username);
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $security->setToken($token);
            $cookie = new Cookie($session->getName(), $session->getId());
            $this->client->getCookieJar()->set($cookie);

            $session->set('user_backend', serialize($token));
            $session->save();
        }

        return $this->um->isAuthenticated();
    }

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->client = static::createClient([], ['HTTP_HOST' => static::$httpHost]);
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->um = static::$kernel->getContainer()->get('backend.user.manager');
        $this->locales = explode("|", static::$kernel->getContainer()->getParameter('locales'));

        parent::setUp();
    }

    protected function tearDown()
    {
        unset($this->client);
        unset($this->dm);

        $refl = new \ReflectionObject($this);
        foreach ($refl->getProperties() as $prop) {
            if ((!($prop->isStatic())) and (0 !== strpos($prop->getDeclaringClass()->getName(), 'PHPUnit_'))) {
                $prop->setAccessible(true);
                $prop->setValue($this, null);
            }
        }

        parent::tearDown();
    }

    protected static function createClient(array $options = array(), array $server = array())
    {
        $client = static::$kernel->getContainer()->get('test.client');
        $client->setServerParameters($server);

        return $client;
    }

    public function getContainer()
    {
        return static::$kernel->getContainer();
    }

    public static function getNextSeed()
    {
        self::$seed += 1;

        return self::$seed;
    }
}
