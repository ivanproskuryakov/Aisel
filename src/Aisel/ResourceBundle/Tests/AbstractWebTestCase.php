<?php

namespace Aisel\ResourceBundle\Tests;

use Buzz\Exception\LogicException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Client;
use Aisel\BackendUserBundle\Manager\UserManager as BackendUsermanager;
use Aisel\FrontendUserBundle\Manager\UserManager as FrontendUsermanager;
use Symfony\Component\Validator\Validator;
use Faker;
use Aisel\BackendUserBundle\Entity\BackendUser;
use Aisel\FrontendUserBundle\Entity\FrontendUser;

/**
 * Class AbstractWebTestCase.
 *
 */
abstract class AbstractWebTestCase extends KernelTestCase
{
    /**
     * @var BackendUser
     */
    protected $backendUser;

    /**
     * @var FrontendUser
     */
    protected $frontendUser;

    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var BackendUsermanager
     */
    protected $backendUserManager;

    /**
     * @var FrontendUsermanager
     */
    protected $frontendUserManager;

    /**
     * @var array $locales
     */
    protected $locales;

    /**
     * @var array $api
     */
    protected $api;

    /**
     * @var Validator
     */
    protected $validator;

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

    /**
     * @param string $httpHost
     */
    public static function setUpBeforeClass($httpHost = 'http://api.aisel.dev')
    {
        static::$httpHost = $httpHost;
    }

    /**
     * @param $entity
     */
    public function removeEntity($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();

        $isFound = $this
            ->em
            ->getRepository(get_class($entity))
            ->findOneBy(['id' => $entity->getId()]);

        $this->assertNull($isFound);
    }

    /**
     * logInBackend
     *
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function logInBackend($username = 'backenduser', $password = 'backenduser')
    {
        if ($this->backendUserManager->getAuthenticatedUser() == false) {

            $this->client->request(
                'GET',
                '/' . $this->api['backend'] . '/user/login/?username=' . $username . '&password=' . $password,
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
        $this->backendUser = $this->backendUserManager->getAuthenticatedUser();

        return $this->backendUser;
    }

    /**
     * logInFrontend
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function logInFrontend($email = 'frontenduser@aisel.co', $password = 'frontenduser')
    {
        if ($this->frontendUserManager->getAuthenticatedUser() == false) {

            $data = [
                'email' => $email,
                'password' => $password,
            ];

            $this->client->request(
                'POST',
                '/' . $this->api['frontend'] . '/user/login/',
                [],
                [],
                ['CONTENT_TYPE' => 'application/json'],
                json_encode($data)
            );


            $response = $this->client->getResponse();
            $content = $response->getContent();
            $result = json_decode($content, true);

            if ($result['status'] !== true) {
                throw new \LogicException('Authentication failed.');
            }
        }
        $this->frontendUser = $this->frontendUserManager->getAuthenticatedUser();

        return $this->frontendUser;
    }

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->client = static::createClient([], ['HTTP_HOST' => static::$httpHost]);
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->backendUserManager = static::$kernel->getContainer()->get('backend.user.manager');
        $this->frontendUserManager = static::$kernel->getContainer()->get('frontend.user.manager');
        $this->locales = explode("|", static::$kernel->getContainer()->getParameter('locales'));
        $this->api = array(
            'frontend' => static::$kernel->getContainer()->getParameter('frontend_api'),
            'backend' => static::$kernel->getContainer()->getParameter('backend_api'),
            'seller' => static::$kernel->getContainer()->getParameter('seller_api')
        );
        $this->validator = static::$kernel->getContainer()->get('validator');
        $this->faker = Faker\Factory::create();

        parent::setUp();
    }

    protected function tearDown()
    {
        unset($this->client);
        unset($this->em);

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
