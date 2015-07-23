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

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Aisel\ResourceBundle\Domain\LocaleTrait;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;

/**
 * Config
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ODM\HasLifecycleCallbacks()
 * @ODM\Document(
 *      collection="aisel_config",
 *      repositoryClass="Aisel\ConfigBundle\Document\ConfigRepository"
 * )
 */
class Config
{

    use LocaleTrait;
    use UpdateCreateTrait;

    /**
     * @var string
     * @ODM\Id
     */
    private $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     */
    private $entity;

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\Type(type="string")
     */
    private $value;

    /**
     * Get id
     *
     * @return string
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
}
