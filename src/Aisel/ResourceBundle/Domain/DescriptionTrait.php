<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Domain;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * DescriptionTrait
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 */
trait DescriptionTrait
{

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotNull()
     * @JMS\Expose
     * @JMS\Type("string")
     */
    private $description;

    /**
     * Set description
     *
     * @param  string $description
     * @return mixed
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

}
