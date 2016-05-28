<?php

namespace Azhuro\Bundle\PageBundle\Controller;

use Azhuro\Bundle\PageBundle\Model\Interfaces\PageInterface;
use Azhuro\Bundle\PageBundle\Twig\Loader\PageTwigLoader;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CmsController extends Controller
{
    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * CmsController constructor.
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param PageInterface $page
     * @return Response
     */
    public function execute(PageInterface $page)
    {
        $loader = new \Twig_Loader_Chain(array(
            $this->twig->getLoader(),
            new PageTwigLoader($page, $this->twig),
        ));

        $this->twig->setLoader($loader);

        $response = new Response();
        // TODO put this in config
        $response->setContent($this->twig->render('AzhuroPageBundle:Index:index.html.twig', array(
            'page' => $page,
        )));

        return $response;
    }
}
