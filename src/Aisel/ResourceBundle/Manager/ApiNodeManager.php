<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Manager;

use LogicException;
use Doctrine\ODM\MongoDB\DocumentManager;
use Aisel\ResourceBundle\Utility\UrlUtility;
use Aisel\ResourceBundle\Document\Node;

/**
 * ApiNodeManager
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ApiNodeManager
{

    /**
     * @var null
     */
    protected $model = null;

    /**
     * @var DocumentManager
     */
    protected $dm;

    /**
     * @var array
     */
    protected $locales;

    /**
     * Constructor
     *
     * @param DocumentManager $dm
     * @param string $locales
     */
    public function __construct(DocumentManager $dm, $locales)
    {
        $this->locales = explode('|', $locales);
        $this->dm = $dm;
    }

    /**
     * Save name for single node
     *
     * @param  array $params
     * @return object
     *
     * @throws LogicException
     */
    public function save($params)
    {
        if ($childId = $params['id']) {
            $node = $this
                ->dm
                ->getRepository($this->model)
                ->find($childId);

            if (!($node)) {
                throw new LogicException('Nothing was found');
            }
        }

        if ($params['name']) {
            $node->setTitle($params['name']);
        }

        $this->dm->persist($node);
        $this->dm->flush();

        return $node;
    }

    /**
     * Remove single node
     *
     * @param  array $params
     * @return object
     *
     * @throws LogicException
     */
    public function remove($params)
    {
        if ($childId = $params['id']) {
            $node = $this->dm->getRepository($this->model)->find($childId);

            if (!($node)) {
                throw new LogicException('Nothing found');
            }
        }

        $this->dm->remove($node);
        $this->dm->flush();

        return $node;
    }

    /**
     * Creates child node
     *
     * @param  array $params
     * @return object
     *
     * @throws LogicException
     */
    public function addChild($params)
    {
        /** @var $node Node */

        if ($childId = $params['parentId']) {
            $parent = $this->dm->getRepository($this->model)->find($childId);

            if (!($parent)) {
                throw new LogicException('Nothing found');
            }
        }
        $node = new $this->nodeEntity();

        $node->setTitle($params['name']);
        $node->setParent($parent);
        $node->setStatus(false);
        $this->dm->persist($node);
        $this->dm->flush();

        return $node;
    }

    /**
     * Creates Node
     *
     * @param  array $params
     * @return object
     *
     * @throws LogicException
     */
    public function addSibling($params)
    {
        $node = new $this->nodeEntity();
        $node->setTitle($params['name']);
        $node->setStatus(false);
        $this->dm->persist($node);
        $this->dm->flush();

        return $node;
    }

    /**
     * Update parent for Node
     *
     * @param  array $params
     * @return Node $child
     *
     * @throws LogicException
     */
    public function updateParent($params)
    {
        /**
         * @var $child Node
         * @var $parent Node
         */
        $repo = $this
            ->dm
            ->getRepository($this->model);

        if ($parentId = $params['parentId']) {
            $parent = $repo->find($parentId);

            if (!$parent) {
                throw new LogicException('Nothing found');
            }
        }

        if ($childId = $params['id']) {
            $child = $repo->find($childId);

            if (!$child) {
                throw new LogicException('Nothing found');
            }
        }

        $child->setParent($parent);
        $this->dm->persist($child);
        $this->dm->flush();

        return $child;
    }

//    @todo: do something with Node URL
//    /**
//     * validate metaUrl for Node Entity and return one we can use
//     *
//     * @param string $url
//     * @param int    $childId
//     *
//     * @return string
//     */
//    public function normalizeNodeUrl($url, $childId = null)
//    {
//        $node = $this->dm->getRepository($this->model)->findTotalByURL($url, $childId);
//        $utility = new UrlUtility();
//        $validUrl = $utility->process($url);
//
//        if ($node) {
//            $validUrl = $validUrl . '-' . time();
//        }
//
//        return $validUrl;
//    }

}
