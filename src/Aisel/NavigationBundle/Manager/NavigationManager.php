<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\NavigationBundle\Manager;

use Aisel\NavigationBundle\Entity\Menu;

/**
 * Manager for Navigation
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class NavigationManager
{
    protected $sc;
    protected $em;

    public function __construct($sc, $em)
    {
        $this->sc = $sc;
        $this->em = $em;
    }

    /**
     * Returns enabled menu
     *
     * @return object
     */
    public function getMenu()
    {
        $menu = $this->em->getRepository('AiselNavigationBundle:Menu')->getEnabledMenuItems();

        return $menu;
    }

    /**
     * Save name for single node
     *
     * @param array $params
     * @return object
     *
     * @throws NotFoundHttpException
     */
    public function save($params)
    {
        if ($categoryId = $params['id']) {
            $menu = $this->em->getRepository('AiselNavigationBundle:Menu')->find($categoryId);
            if (!($menu)) {
                throw new NotFoundHttpException('Nothing found');
            }
        }

        if ($params['name']) $menu->setTitle($params['name']);
        $this->em->persist($menu);
        $this->em->flush();

        return $menu;
    }

    /**
     * Remove single node
     *
     * @param array $params
     * @return object
     *
     * @throws NotFoundHttpException
     */
    public function remove($params)
    {
        if ($categoryId = $params['id']) {
            $menu = $this->em->getRepository('AiselNavigationBundle:Menu')->find($categoryId);
            if (!($menu)) {
                throw new NotFoundHttpException('Nothing found');
            }
        }

        $this->em->remove($menu);
        $this->em->flush();

        return $menu;
    }

    /**
     * Creates child node
     *
     * @param array $params
     * @return object
     *
     * @throws NotFoundHttpException
     */
    public function addChild($params)
    {
        if ($categoryId = $params['parentId']) {
            $menuParent = $this->em->getRepository('AiselNavigationBundle:Menu')->find($categoryId);
            if (!($menuParent)) {
                throw new NotFoundHttpException('Nothing found');
            }
        }

        $menu = new Menu();
        $menu->setTitle($params['name']);
        $menu->setParent($menuParent);
        $menu->setUrl('/#!/');
        $menu->setStatus(false);
        $menu->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $menu->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));

        $this->em->persist($menu);
        $this->em->flush();

        return $menu;
    }

    /**
     * Creates Node
     *
     * @param array $params
     * @return object
     *
     * @throws NotFoundHttpException
     */
    public function addSibling($params)
    {

        $menu = new Menu();
        $menu->setTitle($params['name']);
        $menu->setUrl('/#!/');
        $menu->setStatus(false);
        $menu->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $menu->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));

        $this->em->persist($menu);
        $this->em->flush();

        return $menu;
    }


    /**
     * Update parent for Node
     *
     * @param array $params
     * @return object
     *
     * @throws NotFoundHttpException
     */
    public function updateParent($params)
    {
        if ($categoryParentId = $params['parentId']) {
            $menuParent = $this->em->getRepository('AiselNavigationBundle:Menu')->find($categoryParentId);
            if (!($menuParent)) {
                throw new NotFoundHttpException('Nothing found');
            }
        }

        if ($categoryId = $params['id']) {
            $menu = $this->em->getRepository('AiselNavigationBundle:Menu')->find($categoryId);
            if (!($menu)) {
                throw new NotFoundHttpException('Nothing found');
            }
        }

        $menu->setParent($menuParent);
        $this->em->persist($menu);
        $this->em->flush();

        return $menu;
    }

}
