<?php

namespace Aisel\ProductBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Aisel\ProductBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use Aisel\ResourceBundle\Utility\UrlUtility;

/**
 * Class ProductUrlPersistenceListener.
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ProductUrlPersistenceListener
{

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifeCycleEventArgs $args)
    {
        /** @var Product $object */
        $object = $args->getEntity();
        /** @var EntityManager $em */
        $em = $args->getEntityManager();

        if ($object instanceof Product) {
            $urlUtility = new UrlUtility();
            $processedUrl = $urlUtility->process($object->getMetaUrl());

            $found = $em->getRepository('Aisel\ProductBundle\Entity\Product')
                ->findOneBy(['metaUrl' => $processedUrl]);

            if ($found) {
                throw new \LogicException('Given URL already exists');
            }
        }
    }

}
