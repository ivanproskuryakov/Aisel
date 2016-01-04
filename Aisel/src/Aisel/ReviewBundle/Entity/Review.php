<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ReviewBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

use Aisel\ResourceBundle\Domain\IdTrait;
use Aisel\ResourceBundle\Domain\UpdateCreateTrait;
use Aisel\ResourceBundle\Domain\LocaleTrait;
use Aisel\ResourceBundle\Domain\StatusTrait;
use Aisel\ResourceBundle\Domain\NameTrait;
use Aisel\ResourceBundle\Domain\ContentTrait;
use Aisel\FrontendUserBundle\Entity\FrontendUser;

/**
 * Review
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\MappedSuperclass
 * @JMS\ExclusionPolicy("all")
 */
abstract class Review
{

    use IdTrait;
    use LocaleTrait;
    use StatusTrait;
    use NameTrait;
    use ContentTrait;
    use UpdateCreateTrait;

    /**
     * @var FrontendUser
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="Aisel\FrontendUserBundle\Entity\FrontendUser", inversedBy="reviews")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @JMS\Type("Aisel\FrontendUserBundle\Entity\FrontendUser")
     * @JMS\Expose
     * @JMS\MaxDepth(2)
     */
    private $frontenduser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->nodes = new ArrayCollection();
    }

    /**
     * @return FrontendUser
     */
    public function getFrontenduser()
    {
        return $this->frontenduser;
    }

    /**
     * @param FrontendUser $frontenduser
     */
    public function setFrontenduser($frontenduser)
    {
        $this->frontenduser = $frontenduser;
    }

}
