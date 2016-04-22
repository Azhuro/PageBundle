<?php
/**
 * (c) Johnny Cottereau <johnny.cottereau@gmail.com>
 */

/**
 * (c) Johnny Cottereau <johnny.cottereau@gmail.com>
 */

namespace PageBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use PageBundle\Model\Interfaces\PageInterface;
use PageBundle\Repository\PageRepository;

class BlockManager implements BlockManagerInterface
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var PageRepository
     */
    protected $repository;

    /**
     * PageManager constructor.
     * @param ObjectManager $objectManager
     * @param $class
     */
    public function __construct(ObjectManager $objectManager, $class)
    {
        $this->objectManager = $objectManager;
        $this->repository = $objectManager->getRepository($class);

        $metadata = $objectManager->getClassMetadata($class);
        $this->class = $metadata->getName();
    }

    /**
     * @return PageRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Returns an empty block instance
     *
     * @return PageInterface
     */
    public function createBlock()
    {
        $class = $this->getClass();
        return new $class;
    }

    /**
     * @return array
     */
    public function findBlocks()
    {
        return $this->repository->findAll();
    }
}