<?php

namespace Azhuro\Bundle\PageBundle\Model;

use Azhuro\Bundle\CoreBundle\Model\Traits\TimestampableTrait;
use Azhuro\Bundle\PageBundle\Model\Interfaces\LayoutInterface;
use Doctrine\Common\Collections\ArrayCollection;

use Azhuro\Bundle\PageBundle\Model\Interfaces\BlockInterface;
use Azhuro\Bundle\PageBundle\Model\Interfaces\PageInterface;

use Azhuro\Bundle\PageBundle\Model\Traits\RouteTrait;
use Azhuro\Bundle\PageBundle\Model\Traits\SeoTrait;

/**
 * Page
 */
class Page implements PageInterface
{
    use TimestampableTrait;

    use RouteTrait;

    use SeoTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var boolean
     */
    protected $enabled;

    /**
     * @var ArrayCollection
     */
    protected $blocks;

    /**
     * @var LayoutInterface
     */
    protected $layout;

    ///**
    // * @var string
    // */
    //protected $stylesheet;
    //
    ///**
    // * @var string
    // */
    //protected $javascript;

    public function __construct()
    {
        $this->blocks = new ArrayCollection();
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
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getBlocks()
    {
        return $this->blocks;
    }

    /**
     * @param ArrayCollection $blocks
     * @return $this
     */
    public function setBlocks($blocks)
    {
        $this->blocks = $blocks;

        return $this;
    }

    /**
     * @param BlockInterface $block
     */
    public function addBlock(BlockInterface $block)
    {
        $this->blocks->add($block);
    }

    /**
     * @param BlockInterface $block
     */
    public function removeBlock(BlockInterface $block)
    {
        $this->blocks->removeElement($block);
    }

    /**
     * @return LayoutInterface
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param LayoutInterface $layout
     * @return $this
     */
    public function setLayout(LayoutInterface $layout)
    {
        $this->layout = $layout;

        return $this;
    }

    ///**
    // * @param string $stylesheet
    // * @return Page
    // */
    //public function setStylesheet($stylesheet)
    //{
    //    $this->stylesheet = $stylesheet;
    //
    //    return $this;
    //}
    //
    ///**
    // * @return string
    // */
    //public function getStylesheet()
    //{
    //    return $this->stylesheet;
    //}
    //
    ///**
    // * @param string $javascript
    // * @return Page
    // */
    //public function setJavascript($javascript)
    //{
    //    $this->javascript = $javascript;
    //
    //    return $this;
    //}
    //
    ///**
    // * @return string
    // */
    //public function getJavascript()
    //{
    //    return $this->javascript;
    //}
}
