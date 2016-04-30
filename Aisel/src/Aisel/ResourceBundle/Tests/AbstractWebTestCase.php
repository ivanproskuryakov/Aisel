<?php

namespace Aisel\ResourceBundle\Tests;

use Aisel\UserBundle\Entity\User;
use Aisel\UserBundle\Manager\UserManager as UserManager;
use Doctrine\ORM\EntityManager;
use Faker;
use LogicException;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\Client;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Validator\Validator;

/**
 * Class AbstractWebTestCase.
 *
 */
abstract class AbstractWebTestCase extends KernelTestCase
{

    /**
     * @var User
     */
    protected $user;

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
     * @var UserManager
     */
    protected $userManager;

    /**
     * @var array $locales
     */
    protected $locales;

    /**
     * @var string
     */
    protected $websiteEmail;

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
     * getSwiftMailMessage
     *
     * @return Swift_Message $message
     */
    public function getSwiftMailMessage()
    {
        $mailCollector = $this->client->getProfile()->getCollector('swiftmailer');
        $this->assertEquals(1, $mailCollector->getMessageCount());
        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];

        return $message;
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
     * logInSeller
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function logInSeller($email = 'seller@aisel.co', $password = 'seller')
    {
        $this->logIn($email, $password);
    }

    /**
     * logInBackend
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function logInBackend($email = 'admin@aisel.co', $password = 'admin')
    {
        $this->logIn($email, $password);
    }

    /**
     * logInFrontend
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function logInFrontend($email = 'user@aisel.co', $password = 'user')
    {
        $this->logIn($email, $password);
    }

    /**
     * logIn
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function logIn($email = 'user@aisel.co', $password = 'user')
    {
        if ($this->userManager->getAuthenticatedUser() == false) {

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
            $result = json_decode($response->getContent(), true);

            if ($response->getStatusCode() !== 200) {
                throw new LogicException('Authentication failed.');
            }
            $this->assertEquals($result['user']['email'], $email);
        }
        $this->user = $this->userManager->getAuthenticatedUser();

        return $this->user;
    }

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->client = static::createClient([], ['HTTP_HOST' => static::$httpHost]);
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->userManager = static::$kernel->getContainer()->get('aisel.user.manager');
        $this->locales = explode("|", static::$kernel->getContainer()->getParameter('locales'));
        $this->websiteEmail = static::$kernel->getContainer()->getParameter('website_email');
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
