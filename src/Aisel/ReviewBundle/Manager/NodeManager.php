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

    protected $model = 'Aisel\ReviewBundle\Document\Node';

    /**
     * {@inheritDoc}
     */
    public function addChild($params)
    {

        if ($nodeId = $params['parentId']) {
            $parent = $this->dm->getRepository($this->model)->find($nodeId);

            if (!$parent) {
                throw new LogicException('Nothing found');
            }
        }

        /** @var \Aisel\ReviewBundle\Document\Node $node */
        /** @var \Aisel\ReviewBundle\Document\Node $parent */

        $node = new $this->model();
        $node->setlocale($params['locale']);
        $node->setTitle($params['name']);
        $node->setParent($parent);
        $node->setStatus(false);
        $node->setDescription('');
        $this->dm->persist($node);
        $this->dm->flush();

        return $node;
    }

    /**
     * {@inheritDoc}
     */
    public function addSibling($params)
    {
        /** @var \Aisel\ReviewBundle\Document\Node $node */

        $node = new $this->model();
        $node->setlocale($params['locale']);
        $node->setTitle($params['name']);
        $node->setStatus(false);
        $node->setDescription('');

        $this->dm->persist($node);
        $this->dm->flush();

        return $node;
    }

}
