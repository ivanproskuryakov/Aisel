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
     * Get list of enabled categories sorted as a tree
     * @return object
     */
    public function getHTMLCategoryTree()
    {
//        $categories = $this->em->getRepository('AiselCategoryBundle:Category')->getEnabledCategoriesAsTree();
        $options = array(
            'decorate' => true,
            'rootOpen' => '<ul>',
            'rootClose' => '</ul>',
            'childOpen' => '<li>',
            'childClose' => '</li>',
            'nodeDecorator' => function($node) {
                    return '<a href="#!/category/'.$node['metaUrl'].'">'.$node['title'].'</a>';
                }
        );

        $categories = $this->em->getRepository('AiselCategoryBundle:Category')->childrenHierarchy(
            null, /* starting from root nodes */
            false, /* true: load all children, false: only direct */
            $options
        );

        return $categories;
    }

    /**
     * Get list of all categories
     * @param array $params
     * @return mixed
     */
    public function getCategories($params)
    {
        $total      = $this->em->getRepository('AiselCategoryBundle:Category')->getTotalFromRequest($params);
        $categories = $this->em->getRepository('AiselCategoryBundle:Category')->getCurrentCategoriesFromRequest($params);

        $return = array (
            'total'=> $total,
            'categories'=> $categories
        );

        return $return;
    }


    /**
     * Get single detailed category by URLKey
     * @param int $id
     * @return mixed
     */
    public function getCategoryByURL($urlKey)
    {
        $category = $this->em->getRepository('AiselCategoryBundle:Category')->getEnabledCategoryByUrl($urlKey);

        if(!($category)){
            throw $this->createNotFoundException();
        }


        $pages = $this->em->getRepository('AiselPageBundle:Page')->getPagesByCategory($category->getId());
        $categoryDetails = array('category'=>$category,'pages'=>$pages);

        return $categoryDetails;
    }

    /**
     * Get single category
     * @param int $id
     * @return object
     */
    public function getCategory($id)
    {
        $category = $this->em->getRepository('AiselCategoryBundle:Category')->getEnabledCategory($id);

        if(!($category)){
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
     * @return string
     */
    public function normalizeCategoryUrl($url, $categoryId = null)
    {
        $category = $this->em->getRepository('AiselCategoryBundle:Category')->findTotalByURL($url, $categoryId);

        $utility = new UrlUtility();
        $validUrl = $utility->process($url);

        if ($category) {
            $validUrl = $validUrl. '-1';
        }

        return $validUrl;
    }




}
