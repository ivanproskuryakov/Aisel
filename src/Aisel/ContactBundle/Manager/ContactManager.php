<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ContactBundle\Manager;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContactManager
{
    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * Get contact setting
     * @param array $params
     * @return array
     */
    public function getConfig()
    {
        $config = $this->em->getRepository('AiselConfigBundle:Config')->findOneBy(array('entity' => 'config_contact'));
        if(!($config)){
            throw new NotFoundHttpException('Nothing found');
        }
        return $config;
    }

}
