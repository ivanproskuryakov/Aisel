<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ProductBundle\Entity;

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
 * @ORM\Table(name="aisel_product_review")
 * @ORM\Entity(repositoryClass="Aisel\ResourceBundle\Repository\CollectionRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Review extends BaseReview
{

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Aisel\ProductBundle\Entity\Product", inversedBy="products")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     * @JMS\Type("Aisel\ProductBundle\Entity\Product")
     * @JMS\Expose
     * @JMS\Groups({"collection","details"})
     */
    private $subject;

    /**
     * @return Product
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param Product $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }



}
