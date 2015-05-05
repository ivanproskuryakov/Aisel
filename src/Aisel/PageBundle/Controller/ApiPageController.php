<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Controller;

use Aisel\ResourceBundle\Controller\Admin\AbstractCollectionController;
use Aisel\PageBundle\Entity\Page;

/**
 * ApiPageController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiPageController extends AbstractCollectionController
{

    protected $model = array(
        'class' => "Aisel\PageBundle\Entity\Page",
    );

    /**
     * @param string $urlKey
     * @param string $locale
     *
     * @return Page $page
     */
    public function pageViewByURLAction($urlKey, $locale)
    {
        /** @var \Aisel\PageBundle\Entity\Page $page */
        $page = $this->container->get("aisel.page.manager")->getPageByURL($urlKey, $locale);

        return $page;
    }
}
