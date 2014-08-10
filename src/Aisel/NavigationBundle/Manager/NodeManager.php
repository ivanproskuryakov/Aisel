<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\NavigationBundle\Manager;

use Aisel\CategoryBundle\Manager\AbstractNodeManager;

/**
 * Manager for Navigation Menu Nodes
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class NodeManager extends AbstractNodeManager
{
    protected $repository = 'AiselNavigationBundle:Menu';
    protected $nodeEntity = 'Aisel\NavigationBundle\Entity\Menu';


    /**
     * {@inheritDoc}
     */
    public function addChild($params)
    {
        if ($categoryId = $params['parentId']) {
            $nodeParent = $this->em->getRepository($this->repository)->find($categoryId);
            if (!($nodeParent)) {
                throw new NotFoundHttpException('Nothing found');
            }
        }

        $node = new $this->nodeEntity;
        $node->setTitle($params['name']);
        $node->setParent($nodeParent);
        $node->setMetaUrl('/#!/');
        $node->setStatus(false);
        $node->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $node->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));

        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

    /**
     * {@inheritDoc}
     */
    public function addSibling($params)
    {

        $node = new $this->nodeEntity;
        $node->setTitle($params['name']);
        $node->setMetaUrl('/#!/');
        $node->setStatus(false);
        $node->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $node->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));

        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

}
