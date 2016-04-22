<?php
/**
 * (c) Johnny Cottereau <johnny.cottereau@gmail.com>
 */

namespace Azhuro\Bundle\PageBundle\Manager;

use Doctrine\Common\Persistence\ObjectRepository;

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