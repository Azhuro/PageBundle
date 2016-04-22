<?php

namespace Azhuro\Bundle\PageBundle\Model\Traits;

trait RouteTrait
{
    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $controller;

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    public function hasController()
    {
        return (bool)$this->controller;
    }
}