<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Manager;

use Aisel\CategoryBundle\Manager\AbstractNodeManager;

/**
 * Manager for product categories
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class NodeManager extends AbstractNodeManager
{
    protected $repository = 'AiselProductBundle:Category';
    protected $nodeEntity = 'Aisel\ProductBundle\Entity\Category';

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

        $url = time();
        $node = new $this->nodeEntity;
        $node->setTitle($params['name']);
        $node->setParent($nodeParent);
        $node->setStatus(false);
        $node->setDescription('');
        $node->setMetaUrl($url);
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
        $url = time();
        $node = new $this->nodeEntity;
        $node->setTitle($params['name']);
        $node->setStatus(false);
        $node->setDescription('');
        $node->setMetaUrl($url);
        $node->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $node->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));

        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

}
