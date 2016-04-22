<?php

namespace PageBundle\Router;

use PageBundle\Manager\PageManagerInterface;
use PageBundle\Model\Interfaces\PageInterface;
use PageBundle\Model\Interfaces\RouteInterface;
use Symfony\Cmf\Component\Routing\ChainedRouterInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class DynamicRouter implements ChainedRouterInterface
{
    /**
     * @var PageManagerInterface
     */
    protected $pageManager;

    /**
     * @var RequestContext
     */
    protected $context;

    /**
     * DynamicRouter constructor.
     * @param PageManagerInterface $pageManager
     */
    public function __construct(PageManagerInterface $pageManager)
    {
        $this->pageManager = $pageManager;
    }

    /**
     * @return RouteCollection
     */
    public function getRouteCollection()
    {
        return new RouteCollection();
    }

    /**
     * @param mixed $name
     * @return bool
     */
    public function supports($name)
    {
        //if (is_string($name) && !$this->isPageAlias($name) && !$this->isPageSlug($name)) {
        //    return false;
        //}

        if (is_object($name) && $name instanceof PageInterface) {
            return true;
        }
        return false;
    }

    /**
     * @param mixed $name
     * @param array $parameters
     * @return mixed
     */
    public function getRouteDebugMessage($name, array $parameters = array())
    {
        return $name;
    }

    /**
     * @param string $name
     * @param array $parameters
     * @param int $referenceType
     * @return bool|mixed
     */
    public function generate($name, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        $url = false;

        if ($name instanceof PageInterface && $name instanceof RouteInterface) {
            $url = $this->generateFromPage($name, $parameters, $referenceType);
        }

        if ($url === false) {
            throw new \RuntimeException(sprintf('Page "%d" has no url or customUrl.', $name->getId()));
        }

        return $url;
    }

    /**
     * @param $page
     * @param $parameters
     * @param $referenceType
     * @return mixed
     */
    public function generateFromPage(RouteInterface $page, $parameters, $referenceType)
    {
        $url = $page->getSlug();
        return $this->decorateUrl($url, $parameters, $referenceType);
    }

    /**
     * @param string $pathinfo
     * @return array
     */
    public function match($pathinfo)
    {
        $page = $this->pageManager->findPageBySlug($pathinfo);

        if (!$page instanceof PageInterface) { //TODO finish the exception
            throw new ResourceNotFoundException($pathinfo, 0);
        }

        $cmsController = 'page.controller.cms_controller:execute';

        return array (
            '_controller' => $page->hasController() ? $page->getController() : $cmsController,
            'page'        => $page,
            'path'        => $pathinfo,
            'params'      => array()
        );
    }

    /**
     * Sets the request context.
     *
     * @param RequestContext $context The context
     */
    public function setContext(RequestContext $context)
    {
        $this->context = $context;
    }

    /**
     * Gets the request context.
     *
     * @return RequestContext The context
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Decorates an URL with url context and query
     *
     * @param string      $url           Relative URL
     * @param array       $parameters    An array of parameters
     * @param bool|int    $referenceType The type of reference to be generated (one of the constants)
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected function decorateUrl($url, array $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        if (!$this->context) {
            throw new \RuntimeException('No context associated to the CmsPageRouter');
        }

        $schemeAuthority = '';
        if ($this->context->getHost() && (self::ABSOLUTE_URL === $referenceType || self::NETWORK_PATH === $referenceType)) {
            $port = '';
            if ('http' === $this->context->getScheme() && 80 != $this->context->getHttpPort()) {
                $port = sprintf(':%s', $this->context->getHttpPort());
            } elseif ('https' === $this->context->getScheme() && 443 != $this->context->getHttpsPort()) {
                $port = sprintf(':%s', $this->context->getHttpsPort());
            }

            $schemeAuthority = self::NETWORK_PATH === $referenceType ? '//' : sprintf('%s://', $this->context->getScheme());
            $schemeAuthority = sprintf('%s%s%s', $schemeAuthority, $this->context->getHost(), $port);
        }

        if (self::RELATIVE_PATH === $referenceType) {
            $url =  UrlGenerator::getRelativePath($this->context->getPathInfo(), $url);
        } else {
            $url = sprintf('%s%s%s', $schemeAuthority, $this->context->getBaseUrl(), $url);
        }

        if (count($parameters) > 0) {
            return sprintf('%s?%s', $url, http_build_query($parameters, '', '&'));
        }

        return $url;
    }
}