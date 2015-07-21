<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license infODMation, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Domain;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation as JMS;

/**
 * LocaleTrait
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 *
 */
trait LocaleTrait
{

    /**
     * @var string
     * @ODM\Field(type="string")
     * @Assert\NotNull()
     * @Assert\Length(
     *      min = 2,
     *      max = 2
     * )
     * @JMS\Expose
     * @JMS\Type("string")
     */
    protected $locale;

    /**
     * Set locale
     *
     * @param  string   $locale
     * @return mixed
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
