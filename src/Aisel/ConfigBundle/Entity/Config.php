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

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Config Entity
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Aisel\ConfigBundle\Entity\ConfigRepository")
 * @ORM\Table(name="aisel_config")
 */
class Config
{

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=2, nullable=false)
     * @Assert\NotNull()
     */
    private $locale;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type="string")
     */
    private $entity;

    /**
     * @var string
     * @ORM\Column(type="text")
     * @Assert\NotNull()
     */
    private $value;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set entity
     *
     * @param  string $entity
     * @return Config
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set value
     *
     * @param  string $value
     * @return Config
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set locale
     *
     * @param  string $locale
     * @return Config
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
}
