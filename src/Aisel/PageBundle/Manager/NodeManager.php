<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Manager;

use Aisel\ResourceBundle\Manager\ApiNodeManager;
use LogicException;

/**
 * Manager for page categories
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class NodeManager extends ApiNodeManager
{

    protected $model = 'Aisel\PageBundle\Document\Category';

    /**
     * {@inheritDoc}
     */
    public function addChild($params)
    {

        if ($categoryId = $params['parentId']) {
            $parent = $this->dm->getRepository($this->model)->find($categoryId);

            if (!$parent) {
                throw new LogicException('Nothing found');
            }
        }

        $node = new $this->model();
        $node->setlocale($params['locale']);
        $node->setTitle($params['name']);
        $node->setParent($parent);
        $node->setStatus(false);
        $node->setDescription('');
        $node->setMetaUrl($params['name'] . '_' . time());
        $this->dm->persist($node);
        $this->dm->flush();

        return $node;
    }

    /**
     * {@inheritDoc}
     */
    public function addSibling($params)
    {
        $node = new $this->model();
        $node->setlocale($params['locale']);
        $node->setTitle($params['name']);
        $node->setStatus(false);
        $node->setDescription('');
        $node->setMetaUrl($params['name']);

        $this->dm->persist($node);
        $this->dm->flush();

        return $node;
    }

}
