<?php

namespace Aisel\AddressingBundle\Tests;

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use JMS\Serializer\Serializer;

/**
 * SerializerTestCase
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class SerializerTestCase extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testSerializer()
    {
        $model = "Aisel\AddressingBundle\Entity\Country";

        $country = $this
            ->em
            ->getRepository($model)
            ->findOneBy(['id' => '1003']);

        /** @var Serializer $serializer */
        $serializer = $this->getContainer()->get('jms_serializer');
        $convertedValue = $serializer->deserialize(
            json_encode(['id' => 1003]),
            $model,
            'json'
        );

        var_dump($convertedValue);


//        var_dump($convertedValue);
        exit();

    }

}
