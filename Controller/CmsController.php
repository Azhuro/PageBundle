<?php

namespace PageBundle\Controller;

use PageBundle\Model\Interfaces\PageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

class CmsController extends Controller
{
    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * ServiceController constructor.
     * @param EngineInterface $templating
     */
    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    /**
     * @param PageInterface $page
     * @return Response
     */
    public function execute(PageInterface $page)
    {
        return $this->templating->renderResponse('PageBundle:Index:index.html.twig',
            array(
                'page' => $page
            ));
    }
}