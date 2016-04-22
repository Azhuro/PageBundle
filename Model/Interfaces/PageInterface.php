<?php

namespace Azhuro\Bundle\PageBundle\Model\Interfaces;

use CoreBundle\Model\Interfaces\TimestampableInterface;
use Doctrine\Common\Collections\ArrayCollection;

interface PageInterface extends RouteInterface, SeoInterface, TimestampableInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param string $title
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $content
     */
    public function setContent($content);

    /**
     * @return string
     */
    public function getContent();

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
    public function getBlocks();

    /**
     * @param ArrayCollection $blocks
     */
    public function setBlocks($blocks);

    /**
     * @param BlockInterface $block
     */
    public function addBlock(BlockInterface $block);

    /**
     * @param BlockInterface $block
     */
    public function removeBlock(BlockInterface $block);
    
    ///**
    // * Set stylesheet
    // *
    // * @param string $stylesheet
    // */
    //public function setStylesheet($stylesheet);
    //
    ///**
    // * Get stylesheet
    // *
    // * @return string
    // */
    //public function getStylesheet();
    //
    ///**
    // * Set javascript
    // *
    // * @param string $javascript
    // */
    //public function setJavascript($javascript);
    //
    ///**
    // * Get javascript
    // *
    // * @return string
    // */
    //public function getJavascript();
}