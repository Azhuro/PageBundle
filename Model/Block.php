<?php

namespace Azhuro\Bundle\PageBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Azhuro\Bundle\PageBundle\Model\Interfaces\BlockInterface;
use Azhuro\Bundle\PageBundle\Model\Interfaces\PageInterface;
use Sonata\BlockBundle\Model\Block as BaseBlock;

/**
 * Block
 */
class Block extends BaseBlock implements BlockInterface
{
    /**
     * @var ArrayCollection
     */
    protected $pages;

    public function __construct()
    {
        parent::__construct();
        $this->pages = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param ArrayCollection $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }

    /**
     * @param PageInterface $page
     */
    public function addPage(PageInterface $page)
    {
        $this->pages->add($page);
    }

    /**
     * @param PageInterface $page
     */
    public function removePage(PageInterface $page)
    {
        $this->pages->removeElement($page);
    }
}
