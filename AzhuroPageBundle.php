<?php

namespace Azhuro\Bundle\PageBundle;

use Azhuro\Bundle\CoreBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;

use Azhuro\Bundle\PageBundle\Model\Interfaces\PageInterface;
use Azhuro\Bundle\PageBundle\Model\Interfaces\BlockInterface;
use Azhuro\Bundle\PageBundle\Model\Interfaces\LayoutInterface;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AzhuroPageBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $interfaces = $this->getModelInterfaces();
        if (!empty($interfaces)) {
            $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass($interfaces));
        }
    }

    /**
     * //TODO use entity_resolutions (http://lrotherfield.com/blog/symfony2-tutorial-writing-compiler-pass/)
     *
     * @return array
     */
    public function getModelInterfaces()
    {
        return [
            PageInterface::class    => 'page.entity.page_class',
            BlockInterface::class   => 'page.entity.block_class',
            LayoutInterface::class  => 'page.entity.layout_class'
        ];
    }
}
