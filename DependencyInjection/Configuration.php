<?php

namespace Azhuro\Bundle\PageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Azhuro\Bundle\PageBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('azhuro_page')->children();

        $node
            ->arrayNode('class')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('page')->defaultValue('Application\PageBundle\Entity\Page')->end()
                    ->scalarNode('block')->defaultValue('Application\PageBundle\Entity\Block')->end()
                    ->scalarNode('layout')->defaultValue('Application\PageBundle\Entity\Layout')->end()
            ->end()
            ->end();

        return $treeBuilder;
    }
}