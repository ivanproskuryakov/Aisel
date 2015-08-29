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
 * Manager for product categories
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class NodeManager extends ApiNodeManager
{

    protected $model = 'Aisel\ProductBundle\Document\Category';

    /**
     * {@inheritDoc}
     */
    public function addChild($params)
    {
        if ($categoryId = $params['parentId']) {
            $parent = $this->dm->getRepository($this->model)->find($categoryId);

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
        $this->dm->persist($node);
        $this->dm->flush();

// Update Parent
//        $parent->removeChild($node);
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
        $url = time();
        $node = new $this->model();
        $node->setTitle($params['name']);
        $node->setLocale($params['locale']);
        $node->setStatus(false);
        $node->setDescription('');
        $node->setMetaUrl($url);

        $this->dm->persist($node);
        $this->dm->flush();

        return $node;
    }

}
