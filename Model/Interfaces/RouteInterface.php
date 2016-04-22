<?php

namespace PageBundle\Model\Interfaces;

interface RouteInterface
{
    /**
     * @return string
     */
    public function getController();

    /**
     * @param string $controller
     */
    public function setController($controller);

    /**
     * @return boolean
     */
    public function hasController();

    /**
     * @return string
     */
    public function getSlug();

    /**
     * @param string $slug
     */
    public function setSlug($slug);
}