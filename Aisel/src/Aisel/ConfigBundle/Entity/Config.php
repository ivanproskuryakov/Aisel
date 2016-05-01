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

use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\LocaleTrait;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Config
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="aisel_config")
 * @ORM\Entity(repositoryClass="Aisel\ConfigBundle\Entity\ConfigRepository")
 */
class Config
{

    use IdTrait;
    use LocaleTrait;
    use UpdateCreateTrait;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\Type(type="string")
     */
    private $entity;

    /**
     * @var string
     * @ORM\Column(type="text")
     * @Assert\Type(type="string")
     */
    private $value;

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
}
