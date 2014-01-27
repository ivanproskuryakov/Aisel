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
     * @return json
     */
    public function getPages()
    {
        $pageList = $this->em->getRepository('ProjectxPageBundle:Page')
            ->findAll();

        if(!($pageList)){
            throw $this->createNotFoundException();
        }
        return $pageList;
    }

    /**
     * Get single page
     * @return json
     */
    public function getPage($id)
    {
        $page = $this->em->getRepository('ProjectxPageBundle:Page')
            ->find($id);

        if(!($page)){
            throw $this->createNotFoundException();
        }
        return $page;
    }

}
