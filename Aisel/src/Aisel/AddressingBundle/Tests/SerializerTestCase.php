<?php

namespace Aisel\AddressingBundle\Tests;

use Aisel\AddressingBundle\Entity\Country;
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
        $country = $this
            ->em
            ->getRepository('Aisel\AddressingBundle\Entity\Country')
            ->findOneBy(['iso2' => 'RU']);

        $obj = ['id' => $country->getId()];

        /** @var Serializer $serializer */
        $serializer = $this->getContainer()->get('jms_serializer');
        $convertedValue = $serializer->deserialize(
            json_encode($obj),
            'Aisel\AddressingBundle\Entity\Country',
            'json'
        );

        $this->assertEquals($convertedValue->getIso2(), $country->getIso2());
    }

}
