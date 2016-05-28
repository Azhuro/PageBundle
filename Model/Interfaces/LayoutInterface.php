<?php
/**
 * (c) Johnny Cottereau <johnny.cottereau@gmail.com>
 */

namespace Azhuro\Bundle\PageBundle\Model\Interfaces;

use Azhuro\Bundle\CoreBundle\Model\Interfaces\TimestampableInterface;
use Doctrine\Common\Collections\ArrayCollection;

interface LayoutInterface extends TimestampableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getContent();

    /**
     * @param string $content
     */
    public function setContent($content);

    /**
     * @return boolean
     */
    public function isEnabled();

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled);

    /**
     * @return ArrayCollection
     */
    public function getPages();

    /**
     * @param ArrayCollection $pages
     */
    public function setPages($pages);
}