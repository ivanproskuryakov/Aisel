<?php

namespace Aisel\ResourceBundle\Annotation\Driver;

use Aisel\ResourceBundle\Annotation\Duplicate;
use Doctrine\Common\Annotations\Reader;
use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;

/**
 * DuplicateDriver
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class DuplicateDriver
{

    /**
     * @var Reader
     */
    private $reader;

    /**
     * Constructor
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * prePersist
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getDocument();
        $reflectionProperties = new \ReflectionClass($object);
        $properties = $reflectionProperties->getProperties();
        $annotation = false;
        $property = false;

        foreach ($properties as $prop) {
            $annotation = $this->reader->getPropertyAnnotation(
                $prop,
                'Aisel\ResourceBundle\Annotation\Duplicate'
            );

            if (!empty($annotation)) {
                $property = $prop->getName();
            }
        }

        if (!empty($property)) {
            $getMethod = 'get' . ucFirst($property);

            if (method_exists($object, $getMethod)) {
                $relatedData = $object->{$getMethod}();

                if (count($relatedData) > 1) {
                    var_dump(count($relatedData));
                }
            }
        }
    }
}