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

use LogicException;
use Aisel\ResourceBundle\Manager\ApiNodeManager;

/**
 * Manager for Navigation Menu Nodes
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class NodeManager extends ApiNodeManager
{

    protected $model = 'Aisel\NavigationBundle\Document\Menu';

    /**
     * {@inheritDoc}
     */
    public function addChild($params)
    {
        $repo = $this
            ->dm
            ->getRepository($this->model);

        if ($parentId = $params['parentId']) {
            $parent = $repo->find($parentId);

            if (!$parent) {
                throw new LogicException('Nothing found');
            }
        }

        // our Node
        $node = new $this->model();
        $node->setTitle($params['name']);
        $node->setParent($parent);
        $node->setLocale($params['locale']);
        $node->setMetaUrl('/');
        $node->setStatus(false);
        $this->dm->persist($node);
        $this->dm->flush();

//        // new Parent
//        $parent->addChild($node);
//        $this->dm->persist($parent);
//        $this->dm->flush();

        return $node;
    }

    /**
     * {@inheritDoc}
     */
    public function addSibling($params)
    {
        /**
         * @var $node \Aisel\NavigationBundle\Document\Menu
         */
        $node = new $this->model();
        $node->setTitle($params['name']);
        $node->setLocale($params['locale']);
        $node->setMetaUrl('/');
        $node->setStatus(false);
        $this->dm->persist($node);
        $this->dm->flush();

        return $node;
    }

}
