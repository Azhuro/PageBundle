<?php

namespace PageBundle\Resolver;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerResolver as BaseControllerResolver;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

class ControllerResolver extends BaseControllerResolver
{
    /**
     * @var array
     */
    protected $bundles;

    /**
     * ControllerResolver constructor.
     * @param ContainerInterface $container
     * @param ControllerNameParser $parser
     * @param LoggerInterface|null $logger
     * @param array $bundles
     */
    public function __construct(
        ContainerInterface $container,
        ControllerNameParser $parser,
        LoggerInterface $logger = null,
        $bundles = []
    )
    {
        parent::__construct($container, $parser, $logger);
        $this->bundles = $bundles; //TODO get only accepted bundle in config
    }

    /**
     * @param array $bundles
     * @return array
     */
    public function getBundlesActionsControllersAsString($bundles = array())
    {
        $controllers = [];

        if (!is_array($bundles)) {
            throw new \InvalidArgumentException('The bundles argument is not is array');
        }

        if (empty($bundles)) {
            $bundles = $this->bundles;
        }

        foreach ($bundles as $bundleName => $bundleClass) {
            $bundle = $this->container->get('kernel')->getBundle($bundleName);
            $controllers = array_merge($controllers, $this->getBundleActionsControllersAsString($bundle));
        }

        return $controllers;
    }

    /**
     * @param BundleInterface $bundle
     * @return array
     */
    public function getBundleActionsControllersAsString(BundleInterface $bundle)
    {
        $data = [];

        $reflection = new \ReflectionClass($bundle);
        $controllerDirectory = dirname($reflection->getFileName()) . '/Controller';
        if (!file_exists($controllerDirectory)) {
            return $data;
        }

        /** @var \Directory $d */
        $d = dir($controllerDirectory);
        while (false !== ($entry = $d->read())) {
            if (!preg_match("/^(([A-Z0-9-_]+)Controller).php/i", $entry, $controllerMatches)) {
                continue;
            }

            $controllerName = $controllerMatches[2];

            $class = $reflection->getNamespaceName() . '\Controller\\' . $controllerMatches[1];
            foreach (get_class_methods($class) as $method) {
                if (!preg_match("/^([a-z-_]+)Action/i", $method, $actionMatches)) {
                    continue;
                }

                $controller = sprintf('%s:%s:%s', $bundle->getName(), $controllerName, $actionMatches[1]);

                $data[$controller] = $this->parser->parse($controller);
            }
        }
        $d->close();

        return $data;
    }
}
