<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Entity;

use Aisel\ReviewBundle\Entity\Review as BaseReview;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Review
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="aisel_page_review")
 * @ORM\Entity(repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Review extends BaseReview
{

    /**
     * @var Page
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="Aisel\PageBundle\Entity\Page", inversedBy="pages")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="page_id", referencedColumnName="id", nullable=false)
     * })
     * @JMS\Type("Aisel\PageBundle\Entity\Page")
     * @JMS\Expose
     * @JMS\MaxDepth(2)
     */
    private $subject;

    /**
     * @return Page
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param Page $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }




}
