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

use Aisel\ResourceBundle\Manager\ApiNodeManager;
use LogicException;

/**
 * NodeManager
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class NodeManager extends ApiNodeManager
{

    protected $model = 'Aisel\ProductBundle\Entity\Node';

    /**
     * {@inheritDoc}
     */
    public function addChild($params)
    {
        if ($nodeId = $params['parentId']) {
            $parent = $this->em->getRepository($this->model)->find($nodeId);

            if (!($parent)) {
                throw new LogicException('Nothing found');
            }
        }

        $url = time();
        $node = new $this->model();
        $node->setTitle($params['name']);
        $node->setLocale($params['locale']);
        $node->setParent($parent);
        $node->setStatus(false);
        $node->setDescription('');
        $node->setMetaUrl($url);
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
        $node = new $this->model();
        $node->setTitle($params['name']);
        $node->setLocale($params['locale']);
        $node->setStatus(false);
        $node->setDescription('');
        $node->setMetaUrl($url);

        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

}
