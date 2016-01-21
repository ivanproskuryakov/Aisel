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
 * ContentTrait
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 */
trait ContentTrait
{

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type(type="string")
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\Groups({"collection","details"})
     */
    private $content;

    /**
     * Set content
     *
     * @param  string $content
     * @return mixed
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

}
