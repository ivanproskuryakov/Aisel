<?php

namespace Aisel\ResourceBundle\Annotation\Driver;

use Aisel\ResourceBundle\Annotation\Duplicates;
use Doctrine\Common\Annotations\Reader;
use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;

/**
 * NoDuplicatesDriver
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class NoDuplicatesDriver
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
        $this->findAndRemoveDuplicates($args);
    }

    /**
     * preUpdate
     *
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->findAndRemoveDuplicates($args);
    }

    /**
     * findAndRemoveDuplicates
     *
     * @param LifecycleEventArgs $args
     */
    public function findAndRemoveDuplicates(LifecycleEventArgs $args)
    {
        $object = $args->getDocument();
        $reflectionProperties = new \ReflectionClass($object);
        $objectProperties = $reflectionProperties->getProperties();
        $properties = [];

        foreach ($objectProperties as $prop) {
            $annotation = $this->reader->getPropertyAnnotation(
                $prop,
                'Aisel\ResourceBundle\Annotation\NoDuplicates'
            );

            if (!empty($annotation)) {
                $properties[] = $prop->getName();
            }
        }

        if (!empty($properties)) {

            foreach ($properties as $property) {
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
}