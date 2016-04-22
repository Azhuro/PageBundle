<?php
/**
 * (c) Johnny Cottereau <johnny.cottereau@gmail.com>
 */

namespace Azhuro\Bundle\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug')
            ->add('controller', 'controller_type', array(
                'required' => false
            ))
            ->add('title')
            ->add('enabled')
            ->add('content')
            ->add('metaTitle')
            ->add('metaDescription')
            ->add('metaKeywords')
            //->add('stylesheet')
            //->add('javascript')
        ;
    }

    public function getName()
    {
        return 'page_type';
    }
}
