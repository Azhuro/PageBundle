<?php

namespace Azhuro\Bundle\PageBundle\Admin;

use Azhuro\Bundle\PageBundle\Model\Interfaces\PageInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper

            ->tab('General')
            ->with('General')
            ->add('title')
            ->add('enabled')
            ->add('slug')
            ->add('controller', 'controller_type', array(
                'required' => false
            ))
            ->add('content')
            ->add('layout', 'sonata_type_model', array(
                'property' => 'name',
            ))
            ->end()
            ->end()

            ->tab('Metas')
            ->with('Metas')
            ->add('metaTitle')
            ->add('metaDescription')
            ->add('metaKeywords')
            ->end()
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('layout', 'sonata_type_model', array(
                'property' => 'name',
            ))
            ->add('enabled')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('layout', null, array(), 'entity', array(
                'property' => 'name',
            ))
        ;
    }

    public function toString($object)
    {
        return $object instanceof PageInterface
            ? $object->getTitle()
            : 'New Page';
    }
}