<?php

namespace Azhuro\Bundle\PageBundle\Model\Interfaces;

use CoreBundle\Model\Interfaces\TimestampableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\BlockBundle\Model\BlockInterface as BaseBlockInterface;

interface BlockInterface extends BaseBlockInterface, TimestampableInterface
{
    /**
     * @return ArrayCollection
     */
    public function getPages();

    /**
     * @param ArrayCollection $pages
     */
    public function setPages($pages);

    /**
     * @param PageInterface $page
     */
    public function addPage(PageInterface $page);

    /**
     * @param PageInterface $page
     */
    public function removePage(PageInterface $page);
}