<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\HasArmy;

/**
 * ArmyPointListener
 *
 * @uses EventSubscriber
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class ArmyPointListener implements EventSubscriber
{
    /**
     * getSubscribedEvents
     *
     * @access public
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [ 'onFlush', ];
    }

    /**
     * onFlush
     *
     * @param OnFlushEventArgs $args
     * @access public
     * @return void
     *
     * @ORM\OnFlush
     */
    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();
        $classMetadata = $em->getClassMetadata('Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army');

        $entityList = array_merge(
            $uow->getScheduledEntityInsertions(),
            $uow->getScheduledEntityUpdates(),
            $uow->getScheduledEntityDeletions(),
            $uow->getScheduledCollectionDeletions(),
            $uow->getScheduledCollectionUpdates()
        );

        $treatedArmyList = [];

        foreach ($entityList as $entity) {
            if ($entity instanceof HasArmy) {
                $army = $entity->getArmy();
                if (!isset($treatedArmyList[$army->getId()])) {
                    $army->generatePoints();

                    $uow->recomputeSingleEntityChangeSet($classMetadata, $army);

                    $treatedArmyList[$army->getId()] = $army;
                }
            }
        }
    }
}
