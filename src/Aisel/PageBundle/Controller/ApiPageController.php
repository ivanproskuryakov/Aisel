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

/**
 * Frontend Page REST API controller
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ApiPageController extends Controller
{

    /**
     * Is User Authenticated
     *
     * @return boolean
     */
    private function isAuthenticated()
    {
        return $this->get('frontend.user.manager')->isAuthenticated();
    }

    /**
     * /api/page/list.json?limit=2&current=3
     *
     * @param Request $request
     * @param string  $locale
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse $response
     */
    public function pageListAction(Request $request, $locale)
    {
        $params = array(
            'current' => $request->get('current'),
            'limit' => $request->get('limit'),
            'category' => $request->get('category'),
            'locale' => $request->get('locale')
        );

        if ($request->get('user') && $this->isAuthenticated()) {
            $userid = $this->get('security.context')->getToken()->getUser()->getId();
            $params['userid'] = $userid;
        }
        $pageList = $this->container->get("aisel.page.manager")->getPages($params, $locale);

        return $pageList;
    }

    /**
     * @param string $urlKey
     * @param string $locale
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse $response
     */
    public function pageViewByURLAction($urlKey, $locale)
    {
        /** @var \Aisel\PageBundle\Entity\Page $page */
        $page = $this->container->get("aisel.page.manager")->getPageByURL($urlKey, $locale);

        return $page;
    }
}
