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
use Doctrine\ODM\MongoDB\DocumentManager;
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
        $object = $args->getEntity();
        /** @var DocumentManager $dm */
        $dm = $args->getDocumentManager();

        if ($object instanceof UrlInterface) {
            $urlUtility = new UrlUtility();
            $processedUrl = $urlUtility->process($object->getMetaUrl());

            $found = $dm->getRepository(get_class($object))
                ->findOneBy(['metaUrl' => $processedUrl]);

            if ($found) {
                throw new \LogicException('Given URL already exists');
            }
        }
    }

}
