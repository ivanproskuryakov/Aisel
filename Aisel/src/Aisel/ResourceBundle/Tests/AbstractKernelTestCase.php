<?php

namespace Aisel\ResourceBundle\Tests;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class AbstractKernelTestCase.
 */
abstract class AbstractKernelTestCase extends KernelTestCase
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var KernelInterface
     */
    protected static $kernel = null;

    /**
     * @var integer
     */
    protected static $seed = 1;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->dm = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        parent::setUp();
    }

    protected function tearDown()
    {
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

    public static function getNextSeed()
    {
        self::$seed += 1;

        return self::$seed;
    }
}
