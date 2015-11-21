<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManager;
use Aisel\ResourceBundle\Utility\UrlUtility;
use Aisel\ResourceBundle\Document\UrlInterface;

/**
 * Class UrlPersistenceListener.
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class UrlPersistenceListener
{

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifeCycleEventArgs $args)
    {

        /** @var UrlInterface $object */
        $object = $args->getDocument();

        if ($object instanceof UrlInterface) {

            $urlUtility = new UrlUtility();
            $processedUrl = $urlUtility->process($object->getMetaUrl());

            $found = $args
                ->getEntityManager()
                ->getRepository(get_class($object))
                ->findOneBy(['metaUrl' => $processedUrl]);

            if ($found) {
                throw new \LogicException('Given URL already exists');
            }

            $object->setMetaUrl($processedUrl);

        }
    }

}
