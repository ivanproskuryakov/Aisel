<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ConfigBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception;

/**
 * Config Repository
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ConfigRepository extends EntityRepository
{

    /**
     * Returns all stored settings
     *
     * @param string $locale
     *
     * @return array $config
     */
    public function getAllSettings($locale)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $values = $qb->select('c.entity, c.value, c.locale')
            ->from('AiselConfigBundle:Config', 'c')
            ->getQuery()
            ->execute();
        $config = array();

        foreach ($values as $k => $v) {
            if ($v['locale'] == $locale) $config[$v['entity']] = $v['value'];
        }
        return $config;
    }

    /**
     * Get config data for current entity & locale
     *
     * @param $editLocale
     * @param $entity
     *
     * @return array $entity
     */
    public function getConfig($editLocale, $entity)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $entity = $qb->select('c')
            ->from('AiselConfigBundle:Config', 'c')
            ->where('c.locale = :locale')->setParameter('locale', $editLocale)
            ->andWhere('c.entity = :entity')->setParameter('entity', $entity)
            ->getQuery()
            ->getOneOrNullResult();

        return $entity;
    }

    /**
     * Set config data for current entity & locale
     *
     * @param sting $editLocale
     * @param sting $entity
     * @param sting $value
     *
     * @return boolean $entity
     *
     * @throws \RuntimeException
     */
    public function setConfig($editLocale, $entity, $value)
    {
        $config = $this->getConfig($editLocale, $entity);

        if (!$config) {
            $config = new Config();
        }

        try {
            $config->setlocale($editLocale);
            $config->setEntity($entity);
            $config->setValue($value);
            $this->_em->persist($config);
            $this->_em->flush();

        } catch (Exception $e) {
            throw new \RuntimeException($e);
        }

        return true;
    }
}
