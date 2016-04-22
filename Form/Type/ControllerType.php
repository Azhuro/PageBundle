<?php

namespace Azhuro\Bundle\PageBundle\Form\Type;

use PageBundle\Resolver\ControllerResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ControllerType extends AbstractType
{
    /**
     * @var ControllerResolver
     */
    protected $controllerResolver;

    /**
     * PageType constructor.
     * @param ControllerResolver $controllerResolver
     */
    public function __construct(ControllerResolver $controllerResolver)
    {
        $this->controllerResolver = $controllerResolver;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->controllerResolver->getBundlesActionsControllersAsString(),
        ));
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return ChoiceType::class;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'controller_type';
    }
}