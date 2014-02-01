<?php
namespace Projectx\PageBundle\Manager;

class PageManager
{
    protected $sc;
    protected $em;

    public function __construct($sc,$em)
    {
        $this->sc = $sc;
        $this->em = $em;
    }

    /**
     * Get list of all pages
     * @return page object
     */
    public function getPages($params)
    {
        $total = $this->em->getRepository('ProjectxPageBundle:Page')->getTotalFromRequest($params);
        $pages = $this->em->getRepository('ProjectxPageBundle:Page')->getCurrentPagesFromRequest($params);

        $return = array (
            'total'=> $total,
            'pages'=> $pages
        );

        return $return;
    }

    /**
     * Get single detailed page with category
     * @return mixed array
     */
    public function getPage($id)
    {
        $page = $this->em->getRepository('ProjectxPageBundle:Page')->find($id);

        if(!($page)){
            throw $this->createNotFoundException();
        }

        $pageDetails = array('page'=>$page,'categories'=>array());
        foreach ($page->getCategories() as $c) {
            $category = array();

            $category['id'] = $c->getId();
            $category['title'] = $c->getTitle();
            $category['url'] = $c->getMetaUrl();
            $pageDetails['categories'][$c->getId()] = $category;

        }

        return $pageDetails;
    }

}
