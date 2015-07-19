<?php

namespace Aisel\ProductBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Aisel\ProductBundle\Entity\Category;
use Doctrine\ORM\EntityManager;
use Aisel\ResourceBundle\Utility\UrlUtility;

/**
 * Class CategoryUrlPersistenceListener.
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class CategoryUrlPersistenceListener
{

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifeCycleEventArgs $args)
    {
        /** @var Category $object */
        $object = $args->getEntity();
        /** @var EntityManager $em */
        $em = $args->getEntityManager();

        if ($object instanceof Category) {
            $urlUtility = new UrlUtility();
            $processedUrl = $urlUtility->process($object->getMetaUrl());

            $found = $em->getRepository('Aisel\ProductBundle\Entity\Category')
                ->findOneBy(['metaUrl' => $processedUrl]);

            if ($found) {
                throw new \LogicException('Given URL already exists');
            }
        }
    }

}
