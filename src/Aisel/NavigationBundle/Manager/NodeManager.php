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

use Aisel\ResourceBundle\Manager\ApiNodeManager;

/**
 * Manager for Navigation Menu Nodes
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class NodeManager extends ApiNodeManager
{

    protected $model = 'Aisel\NavigationBundle\Entity\Menu';

    /**
     * {@inheritDoc}
     */
    public function addChild($params)
    {
        /**
         * @var $node \Aisel\NavigationBundle\Entity\Menu
         */
        if ($categoryId = $params['parentId']) {
            $nodeParent = $this->em->getRepository($this->model)->find($categoryId);

            if (!($nodeParent)) {
                throw new \LogicException('Nothing found');
            }
        }

        $node = new $this->model();
        $node->setTitle($params['name']);
        $node->setParent($nodeParent);
        $node->setLocale($params['locale']);
        $node->setMetaUrl('/');
        $node->setStatus(false);
        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

    /**
     * {@inheritDoc}
     */
    public function addSibling($params)
    {
        /**
         * @var $node \Aisel\NavigationBundle\Entity\Menu
         */
        $node = new $this->model();
        $node->setTitle($params['name']);
        $node->setLocale($params['locale']);
        $node->setMetaUrl('/');
        $node->setStatus(false);
        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

}
