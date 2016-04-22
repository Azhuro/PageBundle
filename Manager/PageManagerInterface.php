<?php
/**
 * (c) Johnny Cottereau <johnny.cottereau@gmail.com>
 */

namespace PageBundle\Manager;

use Doctrine\Common\Persistence\ObjectRepository;
use PageBundle\Model\Interfaces\PageInterface;

interface PageManagerInterface
{
    /**
     * @return ObjectRepository
     */
    public function getRepository();

    /**
     * @return string
     */
    public function getClass();

    /**
     * @param $slug
     * @return PageInterface|null
     */
    public function findPageBySlug($slug);

    /**
     * @return PageInterface
     */
    public function createPage();

    /**
     * @param array $criteria
     * @return PageInterface|null
     */
    public function findPageBy(array $criteria);

}