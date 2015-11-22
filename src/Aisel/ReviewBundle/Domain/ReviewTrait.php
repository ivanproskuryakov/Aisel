<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ReviewBundle\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Aisel\ReviewBundle\Entity\Review;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * ReviewTrait
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 *
 */
trait ReviewTrait
{

//    /**
//     * @var ArrayCollection
//     * @ODM\ReferenceMany(targetDocument="Aisel\ReviewBundle\Entity\Review", cascade={"all"})
//     * @JMS\Type("ArrayCollection<Aisel\ReviewBundle\Entity\Review>")
//     * @JMS\Expose
//     * @AiselAnnotation\NoDuplicates()
//     */
//    private $reviews;
//
//    /**
//     * Gets Reviews
//     *
//     * @return Review[]
//     */
//    public function getReviews()
//    {
//        return $this->reviews;
//    }
//
//    /**
//     * Sets Reviews
//     *
//     * @param Review[] $reviews
//     *
//     * @return $this
//     */
//    public function setReviews($reviews)
//    {
//        $this->reviews = $reviews;
//        return $this;
//    }
//
//    /**
//     * Add Review
//     *
//     * @param Review $review
//     *
//     * @return Review
//     */
//    public function addReview(Review $review)
//    {
//        $this->reviews->add($review);
//        return $this;
//    }

    /**
     * Remove Reviews
     *
     * @param Review $review
     */
    public function removeReview(Review $review)
    {
        $this->reviews->removeElement($review);
    }
}
