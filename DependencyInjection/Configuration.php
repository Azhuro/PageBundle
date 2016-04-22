<?php

namespace PageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package PageBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('page')->children();

        $node
            ->arrayNode('class')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('page')->defaultValue('Application\PageBundle\Entity\Page')->end()
                    ->scalarNode('block')->defaultValue('Application\PageBundle\Entity\Block')->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
