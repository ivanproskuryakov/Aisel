<?php

namespace Aisel\ResourceBundle\Tests;

use Buzz\Exception\LogicException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Client;
use Aisel\BackendUserBundle\Manager\UserManager;

/**
 * Class AbstractWebTestCase.
 *
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
     * @var array $api
     */
    protected $api;

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

    public static function setUpBeforeClass($httpHost = 'http://api.aisel.dev')
    {
        static::$httpHost = $httpHost;
    }

    public function logInBackend($username = 'backenduser', $password = 'backenduser')
    {
        if ($this->um->isAuthenticated() === false) {

            $this->client->request(
                'GET',
                '/'. $this->api['backend'] . '/user/login/?username='. $username . '&password='. $password,
                [],
                [],
                ['CONTENT_TYPE' => 'application/json']
            );
            $response = $this->client->getResponse();
            $content = $response->getContent();
            $result = json_decode($content, true);

            if ($result['status'] !== true) {
                throw new \LogicException('Authentication failed.');
            }
        }

        return $this->um->isAuthenticated();
    }

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->client = static::createClient([], ['HTTP_HOST' => static::$httpHost]);
        $this->em = static::$kernel->getContainer()->get('doctrine.odm.mongodb.document_manager');
        $this->um = static::$kernel->getContainer()->get('backend.user.manager');
        $this->locales = explode("|", static::$kernel->getContainer()->getParameter('locales'));
        $this->api = array(
            'frontend' => static::$kernel->getContainer()->getParameter('frontend_api'),
            'backend' => static::$kernel->getContainer()->getParameter('backend_api')
        );

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
