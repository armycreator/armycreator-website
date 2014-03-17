<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Event;

use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * GameEvent
 *
 * @uses GenericEvent
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class GameEvent extends GenericEvent
{
    /**
     * getGameCode
     *
     * @access public
     * @return void
     */
    public function getGameCode()
    {
        return $this->getSubject()->getCode();
    }
}
