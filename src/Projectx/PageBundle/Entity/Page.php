<?php

namespace Projectx\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Page
 */
class Page
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var \DateTime
     */
    private $dateCreated;

    /**
     * @var \DateTime
     */
    private $dateModified;

    /**
     * @var string
     */
    private $pageStatus;

    /**
     * @var boolean
     */
    private $commentStatus;

    /**
     * @var string
     */
    private $metaUrl;

    /**
     * @var string
     */
    private $metaTitle;

    /**
     * @var string
     */
    private $metaDescription;

    /**
     * @var string
     */
    private $metaKeywords;

    public function __toString()
    {
        return $this->getTitle();
    }
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Page
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

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Page
     */
    public function setDateCreated($dateCreated)
    {
        if (!$this->getDateCreated()) {
            if (!$dateCreated) {
                $dateCreated = new \DateTime(date('Y-m-d H:i:s'));
            }

            $this->dateCreated = $dateCreated;
        }

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateModified
     *
     * @param \DateTime $dateModified
     * @return Page
     */
    public function setDateModified($dateModified)
    {
        if (!$dateModified) {
            $dateCreated = new \DateTime(date('Y-m-d H:i:s'));
        }
        $this->dateModified = $dateModified;

        return $this;
    }

    /**
     * Get dateModified
     *
     * @return \DateTime 
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * Set pageStatus
     *
     * @param string $pageStatus
     * @return Page
     */
    public function setPageStatus($pageStatus)
    {
        $this->pageStatus = $pageStatus;

        return $this;
    }

    /**
     * Get pageStatus
     *
     * @return string 
     */
    public function getPageStatus()
    {
        return $this->pageStatus;
    }

    /**
     * Set commentStatus
     *
     * @param boolean $commentStatus
     * @return Page
     */
    public function setCommentStatus($commentStatus)
    {
        $this->commentStatus = $commentStatus;

        return $this;
    }

    /**
     * Get commentStatus
     *
     * @return boolean 
     */
    public function getCommentStatus()
    {
        return $this->commentStatus;
    }

    /**
     * Set metaUrl
     *
     * @param string $metaUrl
     * @return Page
     */
    public function setMetaUrl($metaUrl)
    {
        $this->metaUrl = $metaUrl;

        return $this;
    }

    /**
     * Get metaUrl
     *
     * @return string 
     */
    public function getMetaUrl()
    {
        return $this->metaUrl;
    }

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     * @return Page
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string 
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     * @return Page
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string 
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set metaKeywords
     *
     * @param string $metaKeywords
     * @return Page
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get metaKeywords
     *
     * @return string 
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $categories;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add categories
     *
     * @param \Projectx\PageBundle\Entity\Category $categories
     * @return Page
     */
    public function addCategory(\Projectx\PageBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Projectx\PageBundle\Entity\Category $categories
     */
    public function removeCategory(\Projectx\PageBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
