<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\CategoryBundle\Manager;

use Aisel\AdminBundle\Utility\UrlUtility;

class CategoryManager
{
    protected $sc;
    protected $em;

    public function __construct($sc, $em)
    {
        $this->sc = $sc;
        $this->em = $em;
    }

    /**
     * Get tree array of enabled categories
     * @return array $tree
     */
    public function getCategoryTree()
    {
        $categories = $this->em->getRepository('AiselCategoryBundle:Category')->getEnabledCategoriesAsTree();
        $tree = array();
        foreach ($categories as $rootItem) {

            if (!$rootItem->getStatus()) continue;
            if ($rootItem->getRoot() == $rootItem->getId()) {
                $_category = array(
                    'id' => $rootItem->getId(),
                    'title' => $rootItem->getTitle(),
                    'url' => $rootItem->getMetaUrl(),
                    'selected' => false,
                    'children' => $this->generatePageTree($rootItem->getChildren(), $rootItem->getId())
                );
                $tree[] = $_category;
            }
        }

        return $tree;
    }

    /**
     * Generate child categories for selected root
     * @param  object $items
     * @param  int $pid
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
     * @return string $treeHTML
     */
    public function getHTMLCategoryTree()
    {
        $categories = $this->em->getRepository('AiselCategoryBundle:Category')->getEnabledCategoriesAsTree();
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
     * @param  object $items
     * @param  int $pid
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
     * @param  array $params
     * @return mixed
     */
    public function getCategories($params)
    {
        $total = $this->em->getRepository('AiselCategoryBundle:Category')->getTotalFromRequest($params);
        $categories = $this->em->getRepository('AiselCategoryBundle:Category')->getCurrentCategoriesFromRequest($params);

        $return = array(
            'total' => $total,
            'categories' => $categories
        );

        return $return;
    }

    /**
     * Get single detailed category by URLKey
     * @param  string $urlKey
     * @return mixed
     */
    public function getCategoryByURL($urlKey)
    {
        $category = $this->em->getRepository('AiselCategoryBundle:Category')->getEnabledCategoryByUrl($urlKey);

        if (!($category)) {
            throw $this->createNotFoundException();
        }

        $pages = $this->em->getRepository('AiselPageBundle:Page')->getPagesByCategory($category->getId());
        $categoryDetails = array('category' => $category, 'pages' => $pages);

        return $categoryDetails;
    }

    /**
     * Get single category
     * @param  int $id
     * @return object
     */
    public function getCategory($id)
    {
        $category = $this->em->getRepository('AiselCategoryBundle:Category')->getEnabledCategory($id);

        if (!($category)) {
            throw $this->createNotFoundException();
        }

        return $category;
    }

    /**
     * Get List of all categories, except disabled
     * @return string
     */
    public function getEnabledCategories()
    {
        $pageList = $this->em->getRepository('AiselCategoryBundle:Category')->getEnabledCategoriesAsTree();

        return $pageList;
    }

    /**
     * validate metaUrl for Category Entity and return one we can use
     * @param  string $url
     * @param  int $categoryId
     * @return string
     */
    public function normalizeCategoryUrl($url, $categoryId = null)
    {
        $category = $this->em->getRepository('AiselCategoryBundle:Category')->findTotalByURL($url, $categoryId);
        $utility = new UrlUtility();
        $validUrl = $utility->process($url);

        if ($category) {
            $validUrl = $validUrl . '-' . time();
        }

        return $validUrl;
    }

}
