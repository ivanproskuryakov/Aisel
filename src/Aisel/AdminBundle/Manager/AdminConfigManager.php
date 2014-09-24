<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\AdminBundle\Manager;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Manager to retrieve CMS settings
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class AdminConfigManager
{
    protected $em;

    /**
     * {@inheritDoc}
     */
    public function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * Get all setting
     *
     * @return array $config
     *
     * @throws NotFoundHttpException
     */
    public function getConfig()
    {
        $config = $this->em->getRepository('AiselConfigBundle:Config')->getAllSettings();
        if (!($config)) {
            throw new NotFoundHttpException('Nothing found');
        }

        // inject response unix timestamp
        $config['time'] = time();

        return $config;
    }

}
