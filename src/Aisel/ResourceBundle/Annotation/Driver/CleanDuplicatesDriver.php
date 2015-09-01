<?php

namespace Aisel\ResourceBundle\Annotation\Driver;

use Aisel\ResourceBundle\Annotation\Duplicate;
use Doctrine\Common\Annotations\Reader;
use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;

/**
 * CleanDuplicatesDriver
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class CleanDuplicatesDriver
{

    /**
     * @var Reader
     */
    private $reader;

    /**
     * Constructor
     *
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
        $property = false;

        foreach ($properties as $prop) {
            $annotation = $this->reader->getPropertyAnnotation(
                $prop,
                'Aisel\ResourceBundle\Annotation\CleanDuplicates'
            );

            if (!empty($annotation)) {
                $property = $prop->getName();
            }
        }

        if (!empty($property)) {
            $getMethod = 'get' . ucFirst($property); // ex: getNode
            $removeMethod = substr('remove' . ucFirst($property), 0, -1); // ex: getNodes

            if (method_exists($object, $getMethod)) {
                $assignedDocuments = $object->{$getMethod}();

                if (count($assignedDocuments) > 1) {
                    $ids = array();

                    foreach ($assignedDocuments as $assigned) {
                        $isFound = false;

                        foreach ($ids as $id) {
                            if ($id == $assigned->getId()) {
                                $isFound = true;
                                $object->{$removeMethod}($assigned);
                            }
                        }

                        if ($isFound == false) {
                            $ids[] = $assigned->getId();
                        }
                    }
                }
            }
        }
    }
}