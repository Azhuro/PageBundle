<?php

namespace Azhuro\Bundle\PageBundle\Model\Interfaces;

interface SeoInterface
{
    /**
     * @return string
     */
    public function getMetaTitle();

    /**
     * @param string $metaTitle
     */
    public function setMetaTitle($metaTitle);

    /**
     * @return string
     */
    public function getMetaDescription();

    /**
     * @param string $metaDescription
     */
    public function setMetaDescription($metaDescription);

    /**
     * @return string
     */
    public function getMetaKeywords();

    /**
     * @param string $metaKeywords
     */
    public function setMetaKeywords($metaKeywords);

}