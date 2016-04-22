<?php

namespace Azhuro\Bundle\PageBundle\Twig;

use PageBundle\Templating\Helper\PageHelper;

class PageExtension extends \Twig_Extension
{
    /**
     * @var PageHelper
     */
    protected $pageHelper;

    /**
     * PageExtension constructor.
     * @param PageHelper $pageHelper
     */
    public function __construct(PageHelper $pageHelper)
    {
        $this->pageHelper = $pageHelper;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('page_render',
                array($this->pageHelper, 'render'),
                array('is_safe' => array('html'))
            )
        );
    }

    public function getName()
    {
        return 'page_extension';
    }
}