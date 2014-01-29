<?php
namespace Projectx\PageBundle\Manager;

class SearchManager
{
    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * Get list of results
     * @return json
     */
    public function search($params)
    {
        $total = $this->em->getRepository('ProjectxPageBundle:Page')->getTotalFromRequest($params);
        $pages = $this->em->getRepository('ProjectxPageBundle:Page')->searchFromRequest($params);

        $return = array (
            'total'=> $total,
            'pages'=> $pages
        );

        return $return;
    }


}
