<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\SettingsBundle\Manager;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Manager to retrieve CMS settings
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class SettingsManager
{
    protected $em;
    protected $locale = array();

    /**
     * {@inheritDoc}
     */
    public function __construct($em, $locale, $locales)
    {
        $this->em = $em;
        $this->locale['primary'] = $locale;
        $this->locale['available'] = explode('|', $locales);
    }

    /**
     * Get all setting
     *
     * @param string $locale
     *
     * @return array $config
     *
     * @throws NotFoundHttpException
     */
    public function getConfig($locale = null)
    {
        $config = $this->em->getRepository('AiselConfigBundle:Config')->getAllSettings($locale);

        if (!($config)) {
            throw new NotFoundHttpException('Nothing found');
        }
        $config['settings'] = array();
        $config['settings']['locale'] = $this->locale;
        $config['time'] = time(); // inject response unix timestamp
        return $config;
    }

}
