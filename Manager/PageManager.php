<?php
/**
 * (c) Johnny Cottereau <johnny.cottereau@gmail.com>
 */

namespace Azhuro\Bundle\PageBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use PageBundle\Model\Interfaces\PageInterface;
use PageBundle\Repository\PageRepository;

class PageManager implements PageManagerInterface
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
     * Returns an empty page instance
     *
     * @return PageInterface
     */
    public function createPage()
    {
        $class = $this->getClass();
        return new $class;
    }

    /**
     * @param $slug
     * @return null|PageInterface
     */
    public function findPageBySlug($slug)
    {
        return $this->getRepository()->getPageBySlug($slug);
    }

    /**
     * @return array
     */
    public function findPages()
    {
        return $this->repository->findAll();
    }

    /**
     * @param array $criteria
     * @return null|PageInterface
     */
    public function findPageBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

}