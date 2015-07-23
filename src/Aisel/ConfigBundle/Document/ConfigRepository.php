<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ConfigBundle\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Symfony\Component\Security\Core\Exception;

/**
 * Config Repository
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class ConfigRepository extends DocumentRepository
{

    /**
     * Returns all stored settings
     *
     * @param string $locale
     *
     * @return array $collection
     */
    public function getAllSettings($locale)
    {
        $query = $this
            ->getDocumentManager()
            ->createQueryBuilder($this->getDocumentName());

        if ($locale) {
            $query = $query->field('locale')->equals($locale);
        }
        $collection = $query->getQuery()->execute();

        return $collection;
    }

    /**
     * Get config data for current Document & locale
     *
     * @param string $locale
     * @param string $name
     *
     * @return array $config
     */
    public function getConfig($locale, $name)
    {
        $query = $this
            ->getDocumentManager()
            ->createQueryBuilder($this->getDocumentName())
            ->field('locale')->equals($locale)
            ->field('entity')->equals($name)
            ->getQuery();

        $config = $query->getSingleResult();

        return $config;
    }

    /**
     * saveConfig
     *
     * @param array $settings
     */
    public function saveConfig($settings)
    {
        foreach ($settings as $locale => $entities) {
            foreach ($entities as $document => $value) {
                $this->setConfig($locale, $document, $value);
            }
        }
    }

    /**
     * Set config data for current Document & locale
     *
     * @param string $locale
     * @param string $document
     * @param string $value
     *
     * @throws \RuntimeException
     */
    public function setConfig($locale, $document, $value)
    {
        $config = $this->getConfig($locale, $document);

        if (!$config) {
            $config = new Config();
        }

        try {
            $config->setlocale($locale);
            $config->setEntity($document);
            $config->setValue(json_encode($value));
            $this->getDocumentManager()->persist($config);
            $this->getDocumentManager()->flush();
        } catch (\Exception $e) {
            throw new \RuntimeException($e);
        }
    }
}
