<?php
/**
 * (c) Johnny Cottereau <johnny.cottereau@gmail.com>
 */

/**
 * (c) Johnny Cottereau <johnny.cottereau@gmail.com>
 */

namespace PageBundle\Manager;

use Doctrine\Common\Persistence\ObjectRepository;
use PageBundle\Model\Interfaces\PageInterface;

interface BlockManagerInterface
{
    /**
     * @return ObjectRepository
     */
    public function getRepository();

    /**
     * @return string
     */
    public function getClass();
}