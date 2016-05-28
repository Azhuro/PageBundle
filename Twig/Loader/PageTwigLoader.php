<?php

namespace Azhuro\Bundle\PageBundle\Twig\Loader;

use Azhuro\Bundle\PageBundle\Model\Interfaces\PageInterface;

class PageTwigLoader implements \Twig_LoaderInterface, \Twig_ExistsLoaderInterface
{
    /**
     * @var PageInterface
     */
    protected $page;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * PageTwigLoader constructor.
     * @param PageInterface $page
     * @param \Twig_Environment $twig
     */
    public function __construct(PageInterface $page,  \Twig_Environment $twig)
    {
        $this->page = $page;
        $this->twig = $twig;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getSource($name)
    {
        $source = $this->twig->getLoader()->getSource('AzhuroPageBundle::page_layout.html.twig');

        return str_replace('{{ page_layout }}', $this->page->getLayout()->getContent(), $source);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function exists($name)
    {
        return $name == 'pageLayout.html.twig';
    }

    /**
     * @param string $name
     * @return string
     */
    public function getCacheKey($name)
    {
        return $name;
    }

    /**
     * @param string $name
     * @param int $time
     * @return bool
     */
    public function isFresh($name, $time)
    {
        return true;
    }
}