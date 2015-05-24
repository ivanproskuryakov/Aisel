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
    protected $entity = null;

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
            ->getRepository($this->entity)
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
                ->getRepository($this->entity)
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
            $node = $this->em->getRepository($this->entity)->find($categoryId);

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
            $nodeParent = $this->em->getRepository($this->entity)->find($categoryId);

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
            $nodeParent = $this->em->getRepository($this->entity)->find($categoryParentId);

            if (!($nodeParent)) {
                throw new LogicException('Nothing found');
            }
        }

        if ($categoryId = $params['id']) {
            $node = $this->em->getRepository($this->entity)->find($categoryId);

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
    /**
     * Get tree array of enabled categories
     *
     * @param string $locale
     *
     * @return array $categories
     */
    public function getCategoryTree($locale)
    {
        $categories = $this
            ->em
            ->getRepository($this->entity)
            ->getEnabledCategoriesAsTree($locale);

        return $categories;
    }

    /**
     * Generate child categories for selected root
     *
     * @param object $items
     * @param int    $pid
     *
     * @return array
     */
    public function generatePageTree($items, $pid = null)
    {
        $tree = array();
        foreach ($items as $item) {

            if (!$item->getStatus()) continue;
            if ($item->getParent()) {
                if ($parentId = $item->getParent()->getId()) {
                    if ($parentId == $pid) {
                        $tree[$item->getId()]['id'] = $item->getId();
                        $tree[$item->getId()]['title'] = $item->getTitle();
                        $tree[$item->getId()]['url'] = $item->getMetaUrl();
                        $tree[$item->getId()]['selected'] = false;
                        if ($item->getChildren()) {
                            $children = $this->generatePageTree($item->getChildren(), $item->getId());
                            $tree[$item->getId()]['children'] = $children;
                        }
                    }
                }
            }
        }

        return $tree;
    }

    /**
     * Get enabled categories as HTML "ul li" tree - WILL BE REMOVED
     *
     * @return string $treeHTML
     */
    public function getHTMLCategoryTree()
    {
        $categories = $this->em->getRepository($this->entity)->getEnabledCategoriesAsTree();
        $treeHTML = '<ul>';

        foreach ($categories as $rootItem) {

            if (!$rootItem->getStatus()) continue;
            if ($rootItem->getRoot() == $rootItem->getId()) {

                $treeHTML .= '<li>';
                $treeHTML .= '<a href="/#!/category/' . $rootItem->getMetaUrl() . '">' . $rootItem->getTitle() . '</a>';
                $treeHTML .= '</li>';
                $treeHTML .= $this->generatePageTreeHTML($rootItem->getChildren(), $rootItem->getId());
            }
        }
        $treeHTML .= '</ul>';

        return $treeHTML;
    }

    /**
     * Generate child categories for selected in HTML format - WILL BE REMOVED
     *
     * @param object $items
     * @param int    $pid
     *
     * @return array
     */
    public function generatePageTreeHTML($items, $pid = null)
    {
        $treeHTML = '<ul>';
        foreach ($items as $item) {

            if (!$item->getStatus()) continue;
            if ($item->getParent()) {
                if ($parentId = $item->getParent()->getId()) {
                    if ($parentId == $pid) {
                        $tree[$item->getId()]['title'] = $item->getTitle();
                        if ($item->getChildren()) {
                            $children = $this->generatePageTreeHTML($item->getChildren(), $item->getId());
                            $treeHTML .= '<li>';
                            $treeHTML .= '<a href="/#!/category/' . $item->getMetaUrl() . '">' . $item->getTitle() . '</a>';
                            $treeHTML .= $children;
                            $treeHTML .= '</li>';
                        }
                    }
                }
            }
        }
        $treeHTML .= '</ul>';

        return $treeHTML;
    }

    /**
     * Get list of all categories
     *
     * @param array  $params
     * @param string $locale
     *
     * @return mixed
     */
    public function getCategories($params, $locale = null)
    {
        $total = $this->em->getRepository($this->entity)->getTotalFromRequest($params, $locale);
        $categories = $this->em->getRepository($this->entity)->getCurrentCategoriesFromRequest($params, $locale);
        $return = array(
            'total' => $total,
            'categories' => $categories
        );

        return $return;
    }

    /**
     * Get single detailed category by URLKey
     *
     * @param string $urlKey
     * @param string $locale
     *
     * @throws LogicException
     *
     * @return mixed
     */
    public function getCategoryByURL($urlKey, $locale = null)
    {
        $category = $this->em->getRepository($this->entity)->getEnabledCategoryByUrl($urlKey, $locale);

        if (!($category)) {
            throw new LogicException('Object not found');
        }
        $pages = $this->em->getRepository('AiselPageBundle:Page')->getPagesByCategory($category->getId());
        $categoryDetails = array('category' => $category, 'pages' => $pages);

        return $categoryDetails;
    }

    /**
     * Get single category
     *
     * @param int $id
     *
     * @throws LogicException
     *
     * @return mixed
     */
    public function getCategory($id)
    {
        $category = $this->em->getRepository($this->entity)->getEnabledCategory($id);

        if (!($category)) {
            throw new LogicException('Object not found');
        }
        $pages = $this->em->getRepository('AiselPageBundle:Page')->getPagesByCategory($category->getId());
        $categoryDetails = array('category' => $category, 'pages' => $pages);

        return $categoryDetails;
    }

    /**
     * Get List of all categories, except disabled
     *
     * @return string
     */
    public function getEnabledCategories()
    {
        $pageList = $this->em->getRepository($this->entity)->getEnabledCategoriesAsTree();

        return $pageList;
    }

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
        $category = $this->em->getRepository($this->entity)->findTotalByURL($url, $categoryId);
        $utility = new UrlUtility();
        $validUrl = $utility->process($url);

        if ($category) {
            $validUrl = $validUrl . '-' . time();
        }

        return $validUrl;
    }

}
