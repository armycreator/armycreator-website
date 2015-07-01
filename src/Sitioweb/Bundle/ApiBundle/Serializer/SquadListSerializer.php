<?php

namespace Sitioweb\Bundle\ApiBundle\Serializer;

use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Opium\Component\Layout\LineLayout;
use Opium\OpiumBundle\Entity\Directory;
use Opium\OpiumBundle\Entity\Photo;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army;

class SquadListSerializer implements EventSubscriberInterface
{
    /**
     * onSerializerPreSerialize
     *
     * @param ObjectEvent $event
     * @access public
     * @return void
     */
    public function onSerializerPreSerialize(ObjectEvent $event)
    {
        $object = $event->getObject();
        if ($object instanceof Army) {
            $squadList = $object->getSquadList()->toArray();
            $tmpIds = [];

            foreach ($squadList as $squad) {
                if (!$squad->getName()) {
                    $unitType = $squad->getUnitType();
                    $unitTypeId = $unitType->getId();
                    if (empty($tmpIds[$unitTypeId])) {
                        $tmpIds[$unitTypeId] = 1;
                    } else {
                        $tmpIds[$unitTypeId]++;
                    }

                    $squad->setName($unitType->getName() . ' #' . $tmpIds[$unitTypeId]);
                }
            }
        }
    }

    /**
     * getSubscribedEvents
     *
     * @static
     * @access public
     * @return void
     */
    public static function getSubscribedEvents()
    {
        return array(
            array('event' => 'serializer.pre_serialize', 'method' => 'onSerializerPreSerialize'),
        );
    }
}
