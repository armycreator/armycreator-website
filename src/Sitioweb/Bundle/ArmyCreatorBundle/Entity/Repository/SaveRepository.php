<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class SaveRepository
 *
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class SaveRepository extends EntityRepository
{
    public function save($entityList, $flush = true)
    {
        if (!is_array($entityList)) {
            $entityList = [$entityList];
        }

        $entityManager = $this->getEntityManager();
        foreach ($entityList as $entity) {
            $entityManager->persist($entity);
        }

        if ($flush) {
            $entityManager->flush();
        }
    }

    public function delete($entityList, $flush = true)
    {
        if (!is_array($entityList)) {
            $entityList = [$entityList];
        }

        $entityManager = $this->getEntityManager();

        foreach ($entityList as $entity) {
            $entityManager->remove($entity);
        }

        if ($flush) {
            $entityManager->flush();
        }
    }

    public function flush()
    {
        $entityManager = $this->getEntityManager();
        $entityManager->flush();
    }
}
