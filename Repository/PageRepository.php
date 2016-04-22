<?php

namespace PageBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PageRepository
 *
 */
class PageRepository extends EntityRepository
{
    public function getPageBySlug($slug)
    {
        return $this->findOneBy(['slug' => $slug]);
    }

}
