<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ReviewBundle\Manager;

use Aisel\ResourceBundle\Manager\ApiNodeManager;
use LogicException;

/**
 * Manager for review nodes
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class NodeManager extends ApiNodeManager
{

    protected $model = 'Aisel\ReviewBundle\Entity\Node';

    /**
     * {@inheritDoc}
     */
    public function addChild($params)
    {

        if ($nodeId = $params['parentId']) {
            $parent = $this->em->getRepository($this->model)->find($nodeId);

            if (!$parent) {
                throw new LogicException('Nothing found');
            }
        }

        /** @var \Aisel\ReviewBundle\Entity\Node $node */
        /** @var \Aisel\ReviewBundle\Entity\Node $parent */

        $node = new $this->model();
        $node->setlocale($params['locale']);
        $node->setName($params['name']);
        $node->setParent($parent);
        $node->setStatus(false);
        $node->setContent('');
        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

    /**
     * {@inheritDoc}
     */
    public function addSibling($params)
    {
        /** @var \Aisel\ReviewBundle\Entity\Node $node */

        $node = new $this->model();
        $node->setlocale($params['locale']);
        $node->setName($params['name']);
        $node->setStatus(false);
        $node->setContent('');

        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

}
