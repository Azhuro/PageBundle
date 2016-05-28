<?php

namespace Azhuro\Bundle\PageBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\Definition\Processor;

/**
 * Class AzhuroPageExtension
 * @package Azhuro\Bundle\PageBundle\DependencyInjection
 */
class AzhuroPageExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $container->setParameter('page.entity.page_class', $config['class']['page']);
        $container->setParameter('page.entity.block_class', $config['class']['block']);
        $container->setParameter('page.entity.layout_class', $config['class']['layout']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('form.yml');

        //TODO load only if allow on general config
        $loader->load('admin.yml');
    }
}
