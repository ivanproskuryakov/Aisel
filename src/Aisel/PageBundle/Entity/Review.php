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
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Aisel\ReviewBundle\Entity\Node")
     * @ORM\JoinTable(
     *     name="aisel_page_review_node",
     *     joinColumns={@ORM\JoinColumn(name="review_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="node_id", referencedColumnName="id")}
     * )
     * @JMS\Type("ArrayCollection<Aisel\ReviewBundle\Entity\Node>")
     * @JMS\Expose
     */
    protected $nodes;

    /**
     * @var Page
     * @ORM\ManyToOne(targetEntity="Aisel\PageBundle\Entity\Page", inversedBy="pages")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="page_id", referencedColumnName="id")
     * })
     * @JMS\Type("Aisel\PageBundle\Entity\Page")
     * @JMS\Expose
     */
    private $page;

    /**
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param Page $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

}
