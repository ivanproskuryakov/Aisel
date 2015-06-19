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
use Doctrine\ORM\EntityManager;
use Aisel\ResourceBundle\Utility\UrlUtility;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * AbstractNodeManager
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class AbstractNodeManager
{

    /**
     * @var null
     */
    protected $model = null;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var array
     */
    protected $locales;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     * @param string        $locales
     */
    public function __construct(EntityManager $entityManager, $locales)
    {
        $this->locales = explode('|', $locales);
        $this->em = $entityManager;
    }

    /**
     * Load node tree
     *
     * @param string $locale
     *
     * @return array $nodes
     */
    public function getTree($locale)
    {
        $nodes = $this
            ->em
            ->getRepository($this->model)
            ->findBy(
                array(
                    'locale' => $locale
                )
            );

        return $nodes;
    }

    /**
     * Save name for single node
     *
     * @param  array  $params
     * @return object
     *
     * @throws LogicException
     */
    public function save($params)
    {
        if ($categoryId = $params['id']) {
            $node = $this
                ->em
                ->getRepository($this->model)
                ->find($categoryId);

            if (!($node)) {
                throw new LogicException('Nothing was found');
            }
        }

        if ($params['name']) {
            $node->setTitle($params['name']);
        }
        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

    /**
     * Remove single node
     *
     * @param  array  $params
     * @return object
     *
     * @throws LogicException
     */
    public function remove($params)
    {
        if ($categoryId = $params['id']) {
            $node = $this->em->getRepository($this->model)->find($categoryId);

            if (!($node)) {
                throw new LogicException('Nothing found');
            }
        }

        $this->em->remove($node);
        $this->em->flush();

        return $node;
    }

    /**
     * Creates child node
     *
     * @param  array  $params
     * @return object
     *
     * @throws LogicException
     */
    public function addChild($params)
    {
        if ($categoryId = $params['parentId']) {
            $nodeParent = $this->em->getRepository($this->model)->find($categoryId);

            if (!($nodeParent)) {
                throw new LogicException('Nothing found');
            }
        }

        $node = new $this->nodeEntity();
        $node->setTitle($params['name']);
        $node->setParent($nodeParent);
        $node->setStatus(false);
        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

    /**
     * Creates Node
     *
     * @param  array  $params
     * @return object
     *
     * @throws LogicException
     */
    public function addSibling($params)
    {
        $node = new $this->nodeEntity();
        $node->setTitle($params['name']);
        $node->setStatus(false);
        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

    /**
     * Update parent for Node
     *
     * @param  array  $params
     * @return object
     *
     * @throws LogicException
     */
    public function updateParent($params)
    {
        /**
         * @var $node \Aisel\ResourceBundle\Entity\Category
         */
        if ($categoryParentId = $params['parentId']) {
            $nodeParent = $this->em->getRepository($this->model)->find($categoryParentId);

            if (!($nodeParent)) {
                throw new LogicException('Nothing found');
            }
        }

        if ($categoryId = $params['id']) {
            $node = $this->em->getRepository($this->model)->find($categoryId);

            if (!($node)) {
                throw new LogicException('Nothing found');
            }
        }

        $node->setParent($nodeParent);
        $this->em->persist($node);
        $this->em->flush();

        return $node;
    }

    //---------------------------
    //--------- FRONTEND --------
    //---------------------------

//    /**
//     * Generate child categories for selected root
//     *
//     * @param object $items
//     * @param int    $pid
//     *
//     * @return array
//     */
//    public function generatePageTree($items, $pid = null)
//    {
//        $tree = array();
//        foreach ($items as $item) {
//
//            if (!$item->getStatus()) continue;
//            if ($item->getParent()) {
//                if ($parentId = $item->getParent()->getId()) {
//                    if ($parentId == $pid) {
//                        $tree[$item->getId()]['id'] = $item->getId();
//                        $tree[$item->getId()]['title'] = $item->getTitle();
//                        $tree[$item->getId()]['url'] = $item->getMetaUrl();
//                        $tree[$item->getId()]['selected'] = false;
//                        if ($item->getChildren()) {
//                            $children = $this->generatePageTree($item->getChildren(), $item->getId());
//                            $tree[$item->getId()]['children'] = $children;
//                        }
//                    }
//                }
//            }
//        }
//
//        return $tree;
//    }

    /**
     * validate metaUrl for Category Entity and return one we can use
     *
     * @param string $url
     * @param int    $categoryId
     *
     * @return string
     */
    public function normalizeCategoryUrl($url, $categoryId = null)
    {
        $category = $this->em->getRepository($this->model)->findTotalByURL($url, $categoryId);
        $utility = new UrlUtility();
        $validUrl = $utility->process($url);

        if ($category) {
            $validUrl = $validUrl . '-' . time();
        }

        return $validUrl;
    }

}
