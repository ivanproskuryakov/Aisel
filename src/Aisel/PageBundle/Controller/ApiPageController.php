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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Aisel\PageBundle\Entity\Page;

/**
 * ApiPageController
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiPageController extends Controller
{

    /**
     * pageListAction
     *
     * @param Request $request
     *
     * @return mixed $pageList
     */
    public function pageListAction(Request $request)
    {
        $params = array(
            'current' => $request->get('current'),
            'limit' => $request->get('limit'),
            'category' => $request->get('category'),
            'locale' => $request->get('locale'),
        );
        $pageList = $this->container->get("aisel.page.manager")->getCollection($params);

        return $pageList;
    }

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
