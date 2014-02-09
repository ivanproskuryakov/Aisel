<?php
namespace Aisel\PageBundle\Manager;

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
        $total = $this->em->getRepository('AiselPageBundle:Page')->getTotalFromRequest($params);
        $pages = $this->em->getRepository('AiselPageBundle:Page')->searchFromRequest($params);

        $return = array (
            'total'=> $total,
            'pages'=> $pages
        );

        return $return;
    }


}
