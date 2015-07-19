<?php

namespace Aisel\PageBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Aisel\PageBundle\Entity\Page;
use Doctrine\ORM\EntityManager;
use Aisel\ResourceBundle\Utility\UrlUtility;

/**
 * Class PageUrlPersistenceListener.
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class PageUrlPersistenceListener
{

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifeCycleEventArgs $args)
    {
        /** @var Page $object */
        $object = $args->getEntity();
        /** @var EntityManager $em */
        $em = $args->getEntityManager();

        if ($object instanceof Page) {
            $urlUtility = new UrlUtility();
            $processedUrl = $urlUtility->process($object->getMetaUrl());

            $found = $em->getRepository('Aisel\PageBundle\Entity\Page')
                ->findOneBy(['metaUrl' => $processedUrl]);

            if ($found) {
                throw new \LogicException('Given URL already exists');
            }
        }
    }

}
