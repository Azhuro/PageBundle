<?php

namespace Azhuro\Bundle\PageBundle\EventListener;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadata;

class MappingListener
{
    /**
     * @var string
     */
    protected $blockClass;

    /**
     * @var string
     */
    protected $pageClass;

    /**
     * MappingListener constructor.
     * @param $pageClass
     * @param $blockClass
     */
    public function __construct($pageClass, $blockClass)
    {
        $this->pageClass = $pageClass;
        $this->blockClass = $blockClass;
    }

    /**
     * @param LoadClassMetadataEventArgs $eventArgs
     * @return bool
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        /** @var ClassMetadata $metadata */
        $metadata = $eventArgs->getClassMetadata();

        if ($metadata->isMappedSuperclass) {
            return false;
        }

        $namingStrategy = $eventArgs
            ->getEntityManager()
            ->getConfiguration()
            ->getNamingStrategy();

        $reflexionClass = $metadata->getReflectionClass();

        if ($reflexionClass->implementsInterface('Azhuro\Bundle\PageBundle\Model\Interfaces\PageInterface')) {

            $metadata->mapManyToMany([
                'fieldName' => 'blocks',
                'targetEntity' => $this->blockClass,
                'joinTable' => [
                    'name' => 'page_block_link',
                    'joinColumns' => [
                        [
                            'name' => $namingStrategy->joinKeyColumnName($metadata->getName()),
                            'referencedColumnName' => $namingStrategy->referenceColumnName(),
                            'onDelete' => 'CASCADE',
                            'onUpdate' => 'CASCADE',
                        ],
                    ],
                    'inverseJoinColumns' => [
                        [
                            'name' => 'block_id',
                            'referencedColumnName' => $namingStrategy->referenceColumnName(),
                            'onDelete' => 'CASCADE',
                            'onUpdate' => 'CASCADE',
                        ],
                    ]
                ]
            ]);
        } else if ($reflexionClass->implementsInterface('Azhuro\Bundle\PageBundle\Model\Interfaces\BlockInterface')) {

            $metadata->mapManyToMany([
                'fieldName' => 'pages',
                'targetEntity' => $this->pageClass,
                'joinTable' => [
                    'name' => 'page_block_link',
                    'joinColumns' => [
                        [
                            'name' => $namingStrategy->joinKeyColumnName($metadata->getName()),
                            'referencedColumnName' => $namingStrategy->referenceColumnName(),
                            'onDelete' => 'CASCADE',
                            'onUpdate' => 'CASCADE',
                        ],
                    ],
                    'inverseJoinColumns' => [
                        [
                            'name' => 'page_id',
                            'referencedColumnName' => $namingStrategy->referenceColumnName(),
                            'onDelete' => 'CASCADE',
                            'onUpdate' => 'CASCADE',
                        ],
                    ]
                ]
            ]);

            $metadata->mapOneToMany([
                'fieldName' => 'children',
                'targetEntity' => $this->blockClass,
                'cascade' => array(
                    'remove',
                    'persist',
                ),
                'mappedBy' => 'parent',
                'orphanRemoval' => true,
                'orderBy' => array(
                    'position' => 'ASC',
                )
            ]);

            $metadata->mapManyToOne([
                'fieldName' => 'parent',
                'targetEntity' => $this->blockClass,
                'cascade' => array(
                ),
                'mappedBy' => null,
                'inversedBy' => 'children',
                'joinColumns' => array(
                    array(
                        'name' => 'parent_id',
                        'referencedColumnName' => 'id',
                        'onDelete' => 'CASCADE',
                    ),
                ),
                'orphanRemoval' => false,
            ]);
        }

        return true;
    }
}